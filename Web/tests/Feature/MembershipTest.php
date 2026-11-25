<?php

namespace Tests\Feature;

use App\Models\MembershipTier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MembershipTest extends TestCase
{
    use RefreshDatabase;

    public function test_membership_url_renders_active_membership_plans(): void
    {
        MembershipTier::create([
            'name' => 'Paket Uji',
            'description' => 'Paket untuk pengujian',
            'duration_days' => 30,
            'price' => 25000,
            'monthly_price' => 25000,
            'yearly_price' => 250000,
            'is_active' => true,
            'order' => 1,
        ]);

        $response = $this->get('/membership');

        $response->assertOk()
            ->assertSee('Paket Langganan Member Arema')
            ->assertSee('Paket Uji')
            ->assertSee('25.000');
    }

    public function test_pricing_url_remains_available(): void
    {
        $response = $this->get('/pricing');

        $response->assertOk();
    }

    public function test_membership_url_does_not_render_inactive_membership_plans(): void
    {
        MembershipTier::create([
            'name' => 'Paket Tidak Aktif',
            'description' => 'Paket yang tidak dijual',
            'duration_days' => 30,
            'price' => 25000,
            'monthly_price' => 25000,
            'yearly_price' => 250000,
            'is_active' => false,
            'order' => 1,
        ]);

        $response = $this->get('/membership');

        $response->assertOk()
            ->assertDontSee('Paket Tidak Aktif');
    }
}
