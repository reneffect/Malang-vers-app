<?php

namespace Tests\Feature;

use App\Models\Membership;
use App\Models\MembershipTier;
use App\Models\User;
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

    public function test_membership_page_marks_the_database_plan_as_current(): void
    {
        MembershipTier::create([
            'name' => 'Paket Gratis',
            'slug' => 'gratis',
            'daily_credits' => 100,
            'is_active' => true,
            'order' => 1,
        ]);
        $standardTier = MembershipTier::create([
            'name' => 'Paket Standar',
            'slug' => 'standar',
            'daily_credits' => 1000,
            'is_active' => true,
            'order' => 2,
            'monthly_price' => 19000,
        ]);
        $user = User::factory()->create();
        Membership::create([
            'user_id' => $user->id,
            'membership_tier_id' => $standardTier->id_membership_tier,
            'started_at' => now(),
            'ends_at' => now()->addMonth(),
            'status' => 'active',
        ]);

        $response = $this->actingAs($user)->get('/membership');

        $response->assertOk()
            ->assertSee('STANDAR')
            ->assertSee('1000 kredit per hari')
            ->assertSee('Paket Saat Ini')
            ->assertDontSee('Pilih Paket Standar');
    }
}
