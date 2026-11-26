<?php

namespace App\Http\Controllers;

use App\Models\MembershipTier;
use App\Models\Transaction;
use App\Services\MembershipService;
use App\Services\PaymentProcessorService;
use App\Services\YoBasePayService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function __construct(
        private readonly MembershipService $membershipService,
        private readonly YoBasePayService $yoBasePayService,
        private readonly PaymentProcessorService $paymentProcessor,
    ) {}

    /**
     * Halaman index pembayaran / katalog paket.
     */
    public function index(): View
    {
        $tiers = MembershipTier::active()->orderBy('order')->get();

        return view('payment.index', compact('tiers'));
    }

    /**
     * Inisiasi checkout membership dan tampilkan halaman pembayaran.
     */
    public function checkout(Request $request): View|RedirectResponse
    {
        $validated = $request->validate([
            'tier_id' => ['required', 'integer', 'exists:membership_tiers,id_membership_tier'],
            'billing' => ['nullable', 'in:monthly,yearly'],
        ]);

        $tier = MembershipTier::active()->findOrFail($validated['tier_id']);
        $billing = $validated['billing'] ?? 'monthly';
        $yearlyPrice = (float) $tier->yearly_price > 0
            ? (float) $tier->yearly_price
            : (float) $tier->monthly_price * 12;
        $price = $billing === 'yearly' ? $yearlyPrice : (float) $tier->monthly_price;
        $user = auth()->user();

        // Jika user telah login, buat transaksi dan minta pembayaran ke YoBasePay
        if ($user) {
            try {
                $result = $this->membershipService->createMembershipTransaction($user, $tier, $billing);

                if ($result['is_free']) {
                    return redirect()->route('member.member-home')
                        ->with('success', 'Paket Gratis telah diaktifkan!');
                }

                /** @var Transaction $transaction */
                $transaction = $result['transaction'];
                $payment = $transaction->payment;

                return view('member.checkout', compact('transaction', 'payment', 'tier', 'billing', 'price'));
            } catch (\Exception $e) {
                return redirect()->route('membership.public')
                    ->with('error', 'Pembayaran belum dapat dibuat: '.$e->getMessage());
            }
        }

        return view('member.checkout', compact('tier', 'billing', 'price'));
    }

    /**
     * Tampilkan halaman pembayaran untuk transaksi yang sudah dibuat.
     */
    public function show(string $code): View|RedirectResponse
    {
        $transaction = Transaction::where('transaction_code', $code)
            ->with(['items', 'payment', 'user'])
            ->firstOrFail();

        // Pastikan hanya pemilik yang bisa melihat
        if ((int) auth()->id() !== (int) $transaction->user_id) {
            abort(403, 'Akses tidak sah.');
        }

        $payment = $transaction->payment;
        if (! $payment) {
            abort(404, 'Data pembayaran tidak ditemukan.');
        }

        $tier = null;

        $membershipItem = $transaction->items()->where('item_type', 'membership_tier')->first();
        if ($membershipItem && $membershipItem->membership_tier_id) {
            $tier = MembershipTier::find($membershipItem->membership_tier_id);
        }

        return view('member.checkout', [
            'transaction' => $transaction,
            'payment' => $payment,
            'tier' => $tier,
            'billing' => $membershipItem?->billing_cycle ?? 'monthly',
            'price' => (float) $transaction->total_amount,
        ]);
    }

    /**
     * Endpoint Polling status pembayaran (AJAX dari frontend checkout).
     * Secara otomatis sinkronisasi ke YoBasePay API jika status masih pending.
     */
    public function checkStatus(string $code): JsonResponse
    {
        $transaction = Transaction::where('transaction_code', $code)
            ->where('user_id', auth()->id())
            ->with(['payment'])
            ->firstOrFail();
        $verificationError = null;

        // Jika transaksi masih pending dan belum kedaluwarsa, cek ke YoBasePay API
        if ($transaction->status === 'pending') {
            if ($transaction->expires_at && $transaction->expires_at->isPast()) {
                $this->paymentProcessor->processTransaction($transaction, 'EXPIRED');
            } elseif (! $transaction->payment) {
                $verificationError = 'Data pembayaran transaksi tidak ditemukan.';
                Log::error('Payment status check rejected: local payment record missing', [
                    'transaction_code' => $transaction->transaction_code,
                ]);
            } elseif (! is_string($transaction->payment->provider_reference) || trim($transaction->payment->provider_reference) === '') {
                $verificationError = 'Referensi pembayaran dari gateway tidak ditemukan.';
                Log::error('Payment status check rejected: gateway reference missing', [
                    'transaction_code' => $transaction->transaction_code,
                ]);
            } else {
                try {
                    $gwStatus = $this->yoBasePayService->checkStatus($transaction->payment->provider_reference);
                    $gatewayData = is_array($gwStatus['data'] ?? null) ? $gwStatus['data'] : $gwStatus;
                    $remoteStatus = strtoupper((string) ($gatewayData['status'] ?? ''));

                    if ($remoteStatus === 'SUCCESS') {
                        $result = $this->paymentProcessor->processTransaction($transaction, 'SUCCESS', $gatewayData);
                        if (! $result['success']) {
                            $verificationError = $result['message'];
                        }

                        $transaction->refresh();
                    } elseif (in_array($remoteStatus, ['EXPIRED', 'CANCELLED', 'FAILED'], true)) {
                        $this->paymentProcessor->processTransaction($transaction, $remoteStatus, $gatewayData);
                        $transaction->refresh();
                    } elseif ($remoteStatus !== 'PENDING') {
                        $verificationError = 'Gateway mengembalikan status pembayaran yang tidak valid.';
                        Log::warning('Payment status check received an unknown gateway status', [
                            'transaction_code' => $transaction->transaction_code,
                            'gateway_status' => $remoteStatus,
                        ]);
                    }
                } catch (\Exception $e) {
                    Log::warning('Payment status check failed', [
                        'transaction_code' => $transaction->transaction_code,
                        'exception' => $e,
                    ]);
                    $verificationError = 'Status pembayaran belum dapat diverifikasi. Silakan coba kembali.';
                }
            }
        }

        return response()->json([
            'transaction_code' => $transaction->transaction_code,
            'status' => $transaction->status,
            'is_paid' => $transaction->isPaid(),
            'paid_at' => $transaction->paid_at?->toDateTimeString(),
            'expires_at' => $transaction->expires_at?->toDateTimeString(),
            'verification_error' => $verificationError,
        ]);
    }

    /**
     * Batalkan transaksi yang masih pending.
     */
    public function cancel(string $code): JsonResponse
    {
        $transaction = Transaction::where('transaction_code', $code)
            ->where('user_id', auth()->id())
            ->with('payment')
            ->firstOrFail();

        if ($transaction->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya transaksi berstatus pending yang dapat dibatalkan.',
            ], 422);
        }

        if (! $transaction->payment) {
            return response()->json([
                'success' => false,
                'message' => 'Data pembayaran transaksi tidak ditemukan.',
            ], 422);
        }

        try {
            $gatewayResponse = $this->yoBasePayService->cancelPayment($transaction->transaction_code);
        } catch (\Exception $e) {
            Log::warning('Payment cancellation could not be verified with gateway', [
                'transaction_code' => $transaction->transaction_code,
                'exception' => $e,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Pembatalan belum dapat diverifikasi oleh gateway. Silakan coba kembali.',
            ], 502);
        }

        if (strtoupper((string) ($gatewayResponse['status'] ?? '')) !== 'SUCCESS') {
            Log::warning('Payment cancellation rejected by gateway', [
                'transaction_code' => $transaction->transaction_code,
                'gateway_response' => $gatewayResponse,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gateway belum mengonfirmasi pembatalan pembayaran.',
            ], 502);
        }

        $result = $this->paymentProcessor->processTransaction($transaction, 'CANCELLED');

        if (! $result['success']) {
            return response()->json([
                'success' => false,
                'message' => $result['message'],
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Transaksi berhasil dibatalkan.',
        ]);
    }
}
