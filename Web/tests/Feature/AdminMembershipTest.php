<?php

namespace Tests\Feature;

use App\Models\MembershipTier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminMembershipTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_membership_page_lists_tiers_in_configured_order(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        MembershipTier::create([
            'name' => 'Paket Tahunan',
            'duration_days' => 365,
            'price' => 200000,
            'monthly_price' => 0,
            'yearly_price' => 200000,
            'is_active' => true,
            'order' => 2,
        ]);
        MembershipTier::create([
            'name' => 'Paket Bulanan',
            'duration_days' => 30,
            'price' => 20000,
            'monthly_price' => 20000,
            'yearly_price' => 0,
            'is_active' => true,
            'order' => 1,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.membership'));

        $response->assertOk()
            ->assertSee('Paket Langganan')
            ->assertSee('onclick="toggleModal(\'modalPaket\')"', false)
            ->assertSee('id="modalPaket"', false)
            ->assertSee('function toggleModal(id)', false)
            ->assertSeeInOrder(['Paket Bulanan', 'Paket Tahunan'])
            ->assertSee('Rp 20.000')
            ->assertSee('Rp 200.000');
    }
}
