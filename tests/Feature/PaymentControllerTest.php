<?php

namespace Tests\Feature;

use App\Models\MembershipTier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_membership_plan_links_to_checkout_with_monthly_and_yearly_billing_options(): void
    {
        $tier = MembershipTier::create([
            'name' => 'Paket Premium',
            'slug' => 'premium',
            'duration_days' => 30,
            'price' => 25000,
            'monthly_price' => 25000,
            'yearly_price' => 240000,
            'is_active' => true,
        ]);

        $response = $this->get(route('membership.public'));

        $response->assertOk()
            ->assertSee('Paket Premium');
    }

    public function test_checkout_shows_the_selected_annual_tier_and_price(): void
    {
        $tier = MembershipTier::create([
            'name' => 'Paket Premium',
            'duration_days' => 365,
            'price' => 240000,
            'monthly_price' => 25000,
            'yearly_price' => 240000,
            'is_active' => true,
        ]);

        $response = $this->get(route('payment.checkout', [
            'tier_id' => $tier->getKey(),
            'billing' => 'yearly',
        ]));

        $response->assertOk()
            ->assertViewIs('member.checkout')
            ->assertViewHas('price', 240000.0)
            ->assertSee('Paket Premium (Tahunan)')
            ->assertSee('Rp 240.000');
    }

    public function test_checkout_defaults_to_the_monthly_tier_price(): void
    {
        $tier = MembershipTier::create([
            'name' => 'Paket Bulanan',
            'duration_days' => 30,
            'price' => 25000,
            'monthly_price' => 25000,
            'yearly_price' => 240000,
            'is_active' => true,
        ]);

        $response = $this->get(route('payment.checkout', [
            'tier_id' => $tier->getKey(),
        ]));

        $response->assertOk()
            ->assertViewHas('billing', 'monthly')
            ->assertViewHas('price', 25000.0)
            ->assertSee('Paket Bulanan (Bulanan)')
            ->assertSee('Rp 25.000');
    }

    public function test_standard_checkout_shows_the_tier_credit_quota(): void
    {
        $tier = MembershipTier::create([
            'name' => 'Paket Standar',
            'slug' => 'standar',
            'duration_days' => 30,
            'price' => 19000,
            'monthly_price' => 19000,
            'yearly_price' => 190000,
            'daily_credits' => 1000,
            'is_active' => true,
        ]);

        $response = $this->get(route('payment.checkout', [
            'tier_id' => $tier->getKey(),
        ]));

        $response->assertOk()
            ->assertSee('1.000 kredit harian');
    }

    public function test_checkout_uses_twelve_months_when_the_annual_price_is_not_set(): void
    {
        $tier = MembershipTier::create([
            'name' => 'Paket Bulanan',
            'duration_days' => 30,
            'price' => 25000,
            'monthly_price' => 25000,
            'yearly_price' => 0,
            'is_active' => true,
        ]);

        $response = $this->get(route('payment.checkout', [
            'tier_id' => $tier->getKey(),
            'billing' => 'yearly',
        ]));

        $response->assertOk()
            ->assertViewHas('price', 300000.0)
            ->assertSee('Rp 300.000');
    }

    public function test_checkout_does_not_accept_inactive_membership_tiers(): void
    {
        $tier = MembershipTier::create([
            'name' => 'Paket Tidak Aktif',
            'duration_days' => 30,
            'price' => 25000,
            'monthly_price' => 25000,
            'yearly_price' => 250000,
            'is_active' => false,
        ]);

        $response = $this->get(route('payment.checkout', [
            'tier_id' => $tier->getKey(),
            'billing' => 'monthly',
        ]));

        $response->assertNotFound();
    }
}
