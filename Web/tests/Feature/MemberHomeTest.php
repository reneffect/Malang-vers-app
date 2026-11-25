<?php

namespace Tests\Feature;

use App\Models\Membership;
use App\Models\MembershipTier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemberHomeTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get('/member-home');

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_member_visiting_beranda_is_redirected_to_member_home(): void
    {
        $user = (new User)->forceFill([
            'name' => 'Nama Member',
            'role' => 'member',
        ]);

        $response = $this->actingAs($user)->get('/beranda');

        $response->assertRedirect(route('member.member-home'));
    }

    public function test_authenticated_member_home_renders_history_and_popular_phrases(): void
    {
        $user = (new User)->forceFill([
            'name' => 'Nama Member',
            'role' => 'member',
        ]);

        $response = $this->actingAs($user)->get('/member-home');

        $response->assertOk()
            ->assertSee('Nama Member')
            ->assertSee('Halo, apa kabar? Semoga sehat selalu!')
            ->assertSee('Olah, apu rabak? agomeh tahes ulalas!')
            ->assertSee('Halo apa kabar')
            ->assertSee('Olah apu rabak')
            ->assertDontSee('<i class="fas fa-crown text-amber-400"></i>', false)
            ->assertSee('© 2026 MalangVerse');
    }

    public function test_active_membership_shows_its_tier_in_the_hero_badge(): void
    {
        $user = User::factory()->create([
            'role' => 'member',
        ]);
        $tier = MembershipTier::create([
            'name' => 'Member Premium',
        ]);
        $membership = new Membership;
        $membership->forceFill([
            'user_id' => $user->id,
            'membership_tier_id' => $tier->id_membership_tier,
            'started_at' => now(),
            'ends_at' => now()->addMonth(),
            'status' => 'active',
        ])->save();

        $response = $this->actingAs($user)->get('/member-home');

        $response->assertOk()
            ->assertSee('<i class="fas fa-crown text-amber-400"></i> Member Premium', false)
            ->assertSee('Penerjemah Boso Walikan Member Premium');
    }

    public function test_pending_membership_does_not_show_a_tier_badge(): void
    {
        $user = User::factory()->create([
            'role' => 'member',
        ]);
        $tier = MembershipTier::create([
            'name' => 'Member Premium',
        ]);
        $membership = new Membership;
        $membership->forceFill([
            'user_id' => $user->id,
            'membership_tier_id' => $tier->id_membership_tier,
            'started_at' => now(),
            'ends_at' => now()->addMonth(),
            'status' => 'pending',
        ])->save();

        $response = $this->actingAs($user)->get('/member-home');

        $response->assertOk()
            ->assertDontSee('<i class="fas fa-crown text-amber-400"></i>', false)
            ->assertDontSee('Penerjemah Boso Walikan Member Premium');
    }
}
