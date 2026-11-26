<?php

namespace App\Http\Controllers;

use App\Models\MembershipTier;
use App\Models\Payment;
use App\Models\Transaction;
use App\Services\MembershipService;
use App\Services\PaymentProcessorService;
use App\Services\YoBasePayService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
     * Inisiasi checkout QRIS untuk paket membership dan tampilkan halaman pembayaran.
     */
    public function checkout(Request $request): View|RedirectResponse
    {
        $validated = $request->validate([
            'tier_id' => ['required', 'integer', 'exists:membership_tiers,id_membership_tier'],
            'billing' => ['nullable', 'in:monthly,yearly'],
        ]);

        $tier        = MembershipTier::active()->findOrFail($validated['tier_id']);
        $billing     = $validated['billing'] ?? 'monthly';
        $yearlyPrice = (float) $tier->yearly_price > 0
            ? (float) $tier->yearly_price
            : (float) $tier->monthly_price * 12;
        $price       = $billing === 'yearly' ? $yearlyPrice : (float) $tier->monthly_price;
        $user        = auth()->user();

        // Jika user telah login, buat transaksi riil dan minta QRIS ke YoBasePay
        if ($user) {
            try {
                $result = $this->membershipService->createMembershipTransaction($user, $tier, $billing);

                if ($result['is_free']) {
                    return redirect()->route('member.member-home')
                        ->with('success', 'Paket Gratis telah diaktifkan!');
                }

                /** @var Transaction $transaction */
                $transaction = $result['transaction'];
                $payment     = $transaction->payment;

                return view('member.checkout', compact('transaction', 'payment', 'tier', 'billing', 'price'));
            } catch (\Exception $e) {
                // Fallback ke preview jika ada kendala koneksi
            }
        }

        return view('member.checkout', compact('tier', 'billing', 'price'));
    }

    /**
     * Tampilkan halaman pembayaran QRIS untuk transaksi yang sudah dibuat.
     */
    public function show(string $code): View|RedirectResponse
    {
        $transaction = Transaction::where('transaction_code', $code)
            ->with(['items', 'payment', 'user'])
            ->firstOrFail();

        // Pastikan hanya pemilik yang bisa melihat
        if (auth()->check() && auth()->id() !== $transaction->user_id) {
            abort(403, 'Akses tidak sah.');
        }

        $payment = $transaction->payment;
        $tier = null;

        $membershipItem = $transaction->items()->where('item_type', 'membership_tier')->first();
        if ($membershipItem && $membershipItem->membership_tier_id) {
            $tier = MembershipTier::find($membershipItem->membership_tier_id);
        }

        return view('member.checkout', [
            'transaction' => $transaction,
            'payment'     => $payment,
            'tier'        => $tier,
            'billing'     => 'monthly',
            'price'       => (float) $transaction->total_amount,
        ]);
    }

    /**
     * Endpoint Polling status pembayaran (AJAX dari frontend checkout).
     * Secara otomatis sinkronisasi ke YoBasePay API jika status masih pending.
     */
    public function checkStatus(string $code): JsonResponse
    {
        $transaction = Transaction::where('transaction_code', $code)
            ->with(['payment'])
            ->firstOrFail();

        // Jika transaksi masih pending dan belum kedaluwarsa, cek ke YoBasePay API
        if ($transaction->status === 'pending') {
            if ($transaction->expires_at && $transaction->expires_at->isPast()) {
                $this->paymentProcessor->processTransaction($transaction, 'EXPIRED');
            } else {
                try {
                    $gwStatus = $this->yoBasePayService->checkStatus($transaction->transaction_code);
                    $remoteStatus = strtoupper($gwStatus['status'] ?? '');

                    if ($remoteStatus === 'SUCCESS') {
                        $this->paymentProcessor->processTransaction($transaction, 'SUCCESS', $gwStatus);
                        $transaction->refresh();
                    } elseif (in_array($remoteStatus, ['EXPIRED', 'CANCELLED', 'FAILED'], true)) {
                        $this->paymentProcessor->processTransaction($transaction, $remoteStatus, $gwStatus);
                        $transaction->refresh();
                    }
                } catch (\Exception $e) {
                    // Log error tapi jangan gagalkan polling klien
                }
            }
        }

        return response()->json([
            'transaction_code' => $transaction->transaction_code,
            'status'           => $transaction->status,
            'is_paid'          => $transaction->isPaid(),
            'paid_at'          => $transaction->paid_at?->toDateTimeString(),
            'expires_at'       => $transaction->expires_at?->toDateTimeString(),
        ]);
    }

    /**
     * Batalkan transaksi yang masih pending.
     */
    public function cancel(string $code): JsonResponse
    {
        $transaction = Transaction::where('transaction_code', $code)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if ($transaction->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya transaksi berstatus pending yang dapat dibatalkan.',
            ], 422);
        }

        // Beritahu gateway
        try {
            $this->yoBasePayService->cancelPayment($transaction->transaction_code);
        } catch (\Exception $e) {
            // Lanjutkan pembatalan lokal
        }

        $this->paymentProcessor->processTransaction($transaction, 'CANCELLED');

        return response()->json([
            'success' => true,
            'message' => 'Transaksi berhasil dibatalkan.',
        ]);
    }
}
