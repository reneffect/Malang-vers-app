<?php

namespace App\Http\Controllers;

use App\Models\MembershipTier;
use App\Models\Transaction;
use App\Services\MembershipService;
use App\Services\YoBasePayService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubscriptionController extends Controller
{
    public function __construct(
        private readonly MembershipService $membershipService,
        private readonly YoBasePayService $yoBasePayService,
    ) {}

    /**
     * Halaman pilih paket langganan.
     */
    public function index(): View
    {
        $tiers = MembershipTier::active()->orderBy('order')->get();
        $plans = $tiers;
        $user = auth()->user();
        $currentPlan = $user?->getCurrentPlan();
        $currentPlanSlug = $currentPlan?->slug ?? ($user ? 'gratis' : null);

        return view('member.member-membership', compact(
            'tiers',
            'plans',
            'user',
            'currentPlan',
            'currentPlanSlug',
        ));
    }

    /**
     * Endpoint API AJAX untuk membuat transaksi YoBasePay V4
     * langsung dari modal checkout membership di halaman MalangVerse.
     */
    public function createQris(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'tier_id' => ['required', 'integer', 'exists:membership_tiers,id_membership_tier'],
            'billing' => ['nullable', 'in:monthly,yearly'],
        ]);

        $tier = MembershipTier::active()->findOrFail($validated['tier_id']);
        $billing = $validated['billing'] ?? 'monthly';
        $user = auth()->user();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan login terlebih dahulu.',
            ], 401);
        }

        try {
            $result = $this->membershipService->createMembershipTransaction($user, $tier, $billing);

            if ($result['is_free']) {
                return response()->json([
                    'success' => true,
                    'is_free' => true,
                    'message' => 'Paket Gratis berhasil diaktifkan!',
                ]);
            }

            /** @var Transaction $tx */
            $tx = $result['transaction'];
            $payment = $tx->payment;
            $gateway = $result['gateway'];

            return response()->json([
                'success' => true,
                'is_free' => false,
                'transaction_code' => $tx->transaction_code,
                'amount' => (float) $tx->total_amount,
                'amount_to_pay' => $gateway['amount_to_pay'] ?? null,
                'fee' => $gateway['fee'] ?? null,
                'fee_payer' => $gateway['fee_payer'] ?? null,
                'qr_image' => $payment?->qr_code_url ?? ($gateway['qr_image'] ?? null),
                'qr_string' => $payment?->qr_string ?? ($gateway['qr_string'] ?? null),
                'checkout_url' => $payment?->payment_url ?? ($gateway['checkout_url'] ?? $gateway['payment_url'] ?? null),
                'method_name' => $gateway['method_name'] ?? null,
                'category' => $gateway['category'] ?? $payment?->payment_method,
                'expired_at' => $payment?->expires_at?->format('Y-m-d H:i:s') ?? ($gateway['expired_at'] ?? null),
                'payment_url' => route('payment.show', $tx->transaction_code),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Fallback checkout konvensional (form POST).
     */
    public function checkout(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tier_id' => ['required', 'integer', 'exists:membership_tiers,id_membership_tier'],
            'billing' => ['nullable', 'in:monthly,yearly'],
        ]);

        $tier = MembershipTier::active()->findOrFail($validated['tier_id']);
        $billing = $validated['billing'] ?? 'monthly';
        $user = auth()->user();

        try {
            $result = $this->membershipService->createMembershipTransaction($user, $tier, $billing);

            if ($result['is_free']) {
                return redirect()->route('member.member-home')
                    ->with('success', 'Paket Gratis telah diaktifkan!');
            }

            return redirect()->route('payment.show', $result['transaction']->transaction_code);
        } catch (\Exception $e) {
            return redirect()->route('membership.public')->with('error', $e->getMessage());
        }
    }
}
