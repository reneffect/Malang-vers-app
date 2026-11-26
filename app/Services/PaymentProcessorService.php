<?php

namespace App\Services;

use App\Models\MembershipTier;
use App\Models\Payment;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserEbook;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
     * @param Transaction $transaction
     * @param string $status SUCCESS | EXPIRED | CANCELLED | FAILED
     * @param array $extraData Data tambahan dari gateway (fee, net_amount, ref, dll.)
     * @return array{success: bool, message: string, was_already_processed: bool}
     */
    public function processTransaction(Transaction $transaction, string $status, array $extraData = []): array
    {
        $status = strtoupper($status);

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
                    'success'               => true,
                    'message'               => 'Transaksi sudah diproses sebelumnya.',
                    'was_already_processed' => true,
                ];
            }

            // 2. Tangani Status SUCCESS
            if ($status === 'SUCCESS') {
                $lockedTx->status  = 'paid';
                $lockedTx->paid_at = now();
                $lockedTx->save();

                if ($lockedPayment) {
                    $lockedPayment->status            = 'success';
                    $lockedPayment->paid_at           = now();
                    $lockedPayment->fee               = (float) ($extraData['fee'] ?? $lockedPayment->fee);
                    $lockedPayment->net_amount        = (float) ($extraData['net_amount'] ?? $lockedPayment->net_amount);
                    $lockedPayment->settlement_status = 'holding';
                    $lockedPayment->save();
                }

                // Aktivasi semua item dalam transaksi
                $this->fulfillItems($lockedTx, $extraData['trxid'] ?? $lockedPayment?->provider_reference);

                Log::info("Transaksi {$lockedTx->transaction_code} berhasil diverifikasi dan produk diaktifkan.");

                return [
                    'success'               => true,
                    'message'               => 'Pembayaran berhasil diverifikasi. Produk telah aktif.',
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
                    'success'               => true,
                    'message'               => 'Transaksi telah kedaluwarsa.',
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
                'success'               => true,
                'message'               => "Transaksi dibatalkan/gagal (status: {$status}).",
                'was_already_processed' => false,
            ];
        });
    }

    /**
     * Aktivasi akses produk sesuai item transaksi (Membership atau E-Book).
     */
    private function fulfillItems(Transaction $transaction, ?string $paymentRef): void
    {
        $user = $transaction->user;

        if (! $user) {
            Log::error("Transaksi {$transaction->transaction_code} tidak memiliki user terkait.");
            return;
        }

        $items = $transaction->items()->get();

        foreach ($items as $item) {
            // A. ITEM MEMBERSHIP TIER
            if ($item->isMembership() && $item->membership_tier_id) {
                $tier = MembershipTier::find($item->membership_tier_id);
                if ($tier) {
                    $this->membershipService->activateMembership(
                        $user,
                        $tier,
                        'monthly',
                        $paymentRef ?? $transaction->transaction_code
                    );
                    Log::info("Membership {$tier->name} diaktifkan untuk user #{$user->id}");
                }
            }

            // B. ITEM E-BOOK
            if ($item->isEbook() && $item->ebook_id) {
                UserEbook::updateOrCreate(
                    [
                        'user_id'  => $user->id,
                        'ebook_id' => $item->ebook_id,
                    ],
                    [
                        'acquisition_type' => 'purchased',
                        'price_paid'       => $item->subtotal,
                        'transaction_id'   => $transaction->id,
                        'acquired_at'      => now(),
                    ]
                );
                Log::info("Akses E-Book #{$item->ebook_id} diaktifkan untuk user #{$user->id}");
            }
        }
    }
}
