<?php

namespace App\Http\Controllers;

use App\Models\MembershipTier;
use Illuminate\Contracts\View\View;

class PricingController extends Controller
{
    public function index(): View
    {
        $plans = MembershipTier::active()->get();
        $faqs = collect();
        $user = auth()->user();
        $currentPlanSlug = $user?->getCurrentPlan()?->slug ?? ($user ? 'gratis' : null);

        return view('member.member-membership', compact('plans', 'faqs', 'user', 'currentPlanSlug'));
    }
}
