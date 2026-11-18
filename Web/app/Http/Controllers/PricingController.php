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

        return view('member.member-membership', compact('plans', 'faqs'));
    }
}
