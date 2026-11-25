<?php

namespace App\Http\Controllers;

use App\Models\MembershipTier;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentController extends Controller
{
    /**
     * Halaman pilih paket langganan
     */
    public function index(): View
    {
        $tiers = MembershipTier::where('is_active', true)->orderBy('order')->get();

        return view('payment.index', compact('tiers'));
    }

    /**
     * Halaman checkout (tampilkan modal pembayaran)
     */
    public function checkout(Request $request): View
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

        return view('member.checkout', compact('tier', 'billing', 'price'));
    }
}
