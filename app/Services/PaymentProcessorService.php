<?php

namespace App\Services;

use App\Models\Ebook;
use App\Models\MembershipTier;
use App\Models\Payment;
use App\Models\Transaction;
use App\Models\UserEbook;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RuntimeException;

/**
 * PaymentProcessorService
 *
 * Mengelola pemrosesan status pembayaran (SUCCESS, EXPIRED, CANCELLED, FAILED),
 * verifikasi keabsahan transaksi, dan aktivasi produk (Membership / E-Book)
 * secara idempoten (anti double-execution).
 */
class PaymentProcessorService
{
    public function __construct(
        private readonly MembershipService $membershipService,
    ) {}

    /**
     * Proses hasil pembayaran transaksi secara aman dan idempoten.
     *
     * @param  string  $status  SUCCESS | EXPIRED | CANCELLED | FAILED
     * @param  array  $extraData  Data tambahan dari gateway (fee, net_amount, ref, dll.)
     * @return array{success: bool, message: string, was_already_processed: bool}
     */
    public function processTransaction(Transaction $transaction, string $status, array $extraData = []): array
    {
        $status = strtoupper($status);

        if (! in_array($status, ['SUCCESS', 'EXPIRED', 'CANCELLED', 'FAILED'], true)) {
            return [
                'success' => false,
                'message' => 'Status pembayaran dari gateway tidak valid.',
                'was_already_processed' => false,
            ];
        }

        return DB::transaction(function () use ($transaction, $status, $extraData) {
            /** @var Transaction $lockedTx */
            $lockedTx = Transaction::where('id', $transaction->id)
                ->lockForUpdate()
                ->firstOrFail();

            /** @var Payment|null $lockedPayment */
            $lockedPayment = Payment::where('transaction_id', $lockedTx->id)
                ->lockForUpdate()
                ->first();

            // 1. Cek Idempotensi: Jika transaksi sudah berstatus 'paid', tolak proses ulang
            if ($lockedTx->status === 'paid') {
                Log::info("Transaksi {$lockedTx->transaction_code} sudah berstatus paid sebelumnya. Abaikan.");

                return [
                    'success' => true,
                    'message' => 'Transaksi sudah diproses sebelumnya.',
                    'was_already_processed' => true,
                ];
            }

            // 2. Tangani Status SUCCESS
            if ($status === 'SUCCESS') {
                $validationError = $this->validateSuccessfulPayment($lockedTx, $lockedPayment, $extraData);

                if ($validationError !== null) {
                    Log::warning('Payment fulfillment rejected', [
                        'transaction_code' => $lockedTx->transaction_code,
                        'reason' => $validationError,
                    ]);

                    return [
                        'success' => false,
                        'message' => $validationError,
                        'was_already_processed' => false,
                    ];
                }

                $lockedTx->status = 'paid';
                $lockedTx->paid_at = now();
                $lockedTx->save();

                $lockedPayment->status = 'success';
                $lockedPayment->paid_at = now();
                $lockedPayment->fee = (float) ($extraData['fee'] ?? $lockedPayment->fee);
                $lockedPayment->net_amount = (float) ($extraData['net_amount'] ?? $lockedPayment->net_amount);
                $lockedPayment->settlement_status = 'holding';
                $lockedPayment->save();

                $this->fulfillItems($lockedTx, $lockedPayment->provider_reference);

                Log::info("Transaksi {$lockedTx->transaction_code} berhasil diverifikasi dan produk diaktifkan.");

                return [
                    'success' => true,
                    'message' => 'Pembayaran berhasil diverifikasi. Produk telah aktif.',
                    'was_already_processed' => false,
                ];
            }

            // 3. Tangani Status EXPIRED
            if ($status === 'EXPIRED') {
                $lockedTx->status = 'expired';
                $lockedTx->save();

                if ($lockedPayment) {
                    $lockedPayment->status = 'expired';
                    $lockedPayment->save();
                }

                Log::info("Transaksi {$lockedTx->transaction_code} ditandai sebagai expired.");

                return [
                    'success' => true,
                    'message' => 'Transaksi telah kedaluwarsa.',
                    'was_already_processed' => false,
                ];
            }

            // 4. Tangani Status CANCELLED / FAILED
            $lockedTx->status = 'cancelled';
            $lockedTx->save();

            if ($lockedPayment) {
                $lockedPayment->status = 'failed';
                $lockedPayment->save();
            }

            Log::info("Transaksi {$lockedTx->transaction_code} berstatus {$status}.");

            return [
                'success' => true,
                'message' => "Transaksi dibatalkan/gagal (status: {$status}).",
                'was_already_processed' => false,
            ];
        });
    }

    /**
     * Verify the gateway payment and its local transaction snapshot before fulfillment.
     */
    private function validateSuccessfulPayment(Transaction $transaction, ?Payment $payment, array $extraData): ?string
    {
        if (! $payment) {
            return 'Data pembayaran tidak ditemukan.';
        }

        $supportedMethods = ['qris', 'virtual_account', 'emoney', 'retail', 'pulsa', 'smartpay', 'bank_transfer', 'manual'];

        if (
            $payment->payment_provider !== 'yobasepay'
            || ! in_array($payment->payment_method, $supportedMethods, true)
        ) {
            return 'Metode pembayaran tidak sesuai dengan transaksi.';
        }

        if (! is_string($payment->provider_reference) || trim($payment->provider_reference) === '') {
            return 'Referensi pembayaran dari gateway tidak tersedia.';
        }

        $expectedAmount = (float) $transaction->total_amount;

        if ($expectedAmount <= 0 || abs((float) $payment->amount - $expectedAmount) > 0.01) {
            return 'Nominal pada data pembayaran tidak cocok dengan transaksi.';
        }

        $requestedAmount = $extraData['amount_request'] ?? null;

        if (
            $requestedAmount !== null
            && (! is_numeric($requestedAmount) || abs((float) $requestedAmount - $expectedAmount) > 0.01)
        ) {
            return 'Nominal permintaan yang dilaporkan gateway tidak cocok dengan transaksi.';
        }

        $gatewayFee = $extraData['fee'] ?? null;

        if ($gatewayFee !== null && (! is_numeric($gatewayFee) || (float) $gatewayFee < 0)) {
            return 'Biaya yang dilaporkan gateway tidak valid.';
        }

        foreach (['amount', 'amount_to_pay'] as $chargeField) {
            if (! array_key_exists($chargeField, $extraData)) {
                continue;
            }

            $chargeAmount = $extraData[$chargeField];
            $matchesBaseAmount = is_numeric($chargeAmount)
                && abs((float) $chargeAmount - $expectedAmount) <= 0.01;
            $matchesFeeInclusiveAmount = is_numeric($chargeAmount)
                && is_numeric($gatewayFee)
                && abs((float) $chargeAmount - ($expectedAmount + (float) $gatewayFee)) <= 0.01;

            if (! $matchesBaseAmount && ! $matchesFeeInclusiveAmount) {
                return 'Nominal tagihan gateway tidak cocok dengan transaksi dan biaya yang dilaporkan.';
            }
        }

        $reportedReference = $extraData['trxid'] ?? $extraData['trx_id'] ?? null;

        if ($reportedReference !== null && (string) $reportedReference !== $payment->provider_reference) {
            return 'Referensi pembayaran gateway tidak cocok dengan transaksi.';
        }

        if (isset($extraData['ref_id']) && (string) $extraData['ref_id'] !== $transaction->transaction_code) {
            return 'Kode referensi transaksi dari gateway tidak cocok.';
        }

        $items = $transaction->items()->get();

        if ($items->count() !== 1) {
            return 'Transaksi harus memiliki tepat satu item yang valid.';
        }

        $item = $items->first();
        $itemSubtotal = (float) $item->subtotal;

        if (
            (int) $item->quantity !== 1
            || abs($itemSubtotal - $expectedAmount) > 0.01
            || abs(((float) $item->unit_price * (int) $item->quantity) - $itemSubtotal) > 0.01
        ) {
            return 'Rincian item transaksi tidak cocok dengan nominal pembayaran.';
        }

        if ($item->isMembership()) {
            if (! $item->membership_tier_id || ! MembershipTier::query()->whereKey($item->membership_tier_id)->exists()) {
                return 'Paket membership pada transaksi tidak ditemukan.';
            }

            if (! in_array($item->billing_cycle ?? 'monthly', ['monthly', 'yearly'], true)) {
                return 'Siklus paket membership pada transaksi tidak valid.';
            }
        } elseif ($item->isEbook()) {
            if (! $item->ebook_id || ! Ebook::query()->whereKey($item->ebook_id)->exists()) {
                return 'E-Book pada transaksi tidak ditemukan.';
            }
        } else {
            return 'Jenis item transaksi tidak valid.';
        }

        return null;
    }

    /**
     * Activate the verified product represented by the transaction item.
     */
    private function fulfillItems(Transaction $transaction, string $paymentRef): void
    {
        $user = $transaction->user;

        if (! $user) {
            throw new RuntimeException("Transaksi {$transaction->transaction_code} tidak memiliki user terkait.");
        }

        $items = $transaction->items()->get();

        foreach ($items as $item) {
            if ($item->isMembership()) {
                $tier = $item->membershipTier()->firstOrFail();

                $this->membershipService->activateMembership(
                    $user,
                    $tier,
                    $item->billing_cycle ?? 'monthly',
                    $paymentRef
                );

                Log::info("Membership {$tier->name} diaktifkan untuk user #{$user->id}");
            } elseif ($item->isEbook()) {
                UserEbook::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'ebook_id' => $item->ebook_id,
                    ],
                    [
                        'acquisition_type' => 'purchased',
                        'price_paid' => $item->subtotal,
                        'transaction_id' => $transaction->id,
                        'acquired_at' => now(),
                    ]
                );
                Log::info("Akses E-Book #{$item->ebook_id} diaktifkan untuk user #{$user->id}");
            } else {
                throw new RuntimeException('Jenis item transaksi tidak valid.');
            }
        }
    }
}
