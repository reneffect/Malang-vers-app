<?php

namespace Tests\Feature;

use App\Models\Membership;
use App\Models\MembershipTier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NavbarTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_sees_login_and_registration_links(): void
    {
        $response = $this->get('/beranda');

        $response->assertOk()
            ->assertSee('Masuk')
            ->assertSee('Daftar');
    }

    public function test_guest_does_not_see_the_member_navbar_on_the_ebook_catalog(): void
    {
        $response = $this->get(route('kamus'));

        $response->assertOk()
            ->assertDontSee('profile-dropdown')
            ->assertDontSee('Translator');
    }

    public function test_authenticated_member_sees_their_name_linked_to_member_home(): void
    {
        MembershipTier::create([
            'name' => 'Paket Gratis',
            'slug' => 'gratis',
            'daily_credits' => 100,
        ]);
        $user = User::factory()->create([
            'name' => 'Nama Member',
            'role' => 'member',
        ]);

        $response = $this->actingAs($user)->get('/member-home');

        $response->assertOk()
            ->assertSee('Nama Member')
            ->assertSee('GRATIS')
            ->assertDontSee('PRO')
            ->assertSee('profile-dropdown')
            ->assertSee('data-navbar-avatar')
            ->assertSee('Profil Saya')
            ->assertSee('href="'.route('profile.index').'"', false)
            ->assertSee('href="'.route('member.member-home').'"', false)
            ->assertSee('action="'.route('logout').'"', false)
            ->assertDontSee('href="'.route('login').'"', false);
    }

    public function test_authenticated_member_sees_the_badge_for_their_active_database_plan(): void
    {
        $user = User::factory()->create([
            'role' => 'member',
        ]);
        $tier = MembershipTier::create([
            'name' => 'Paket Standar',
            'slug' => 'standar',
            'daily_credits' => 1000,
        ]);
        Membership::create([
            'user_id' => $user->id,
            'membership_tier_id' => $tier->id_membership_tier,
            'started_at' => now(),
            'ends_at' => now()->addMonth(),
            'status' => 'active',
        ]);

        $response = $this->actingAs($user)->get('/member-home');

        $response->assertOk()
            ->assertSee('STANDAR')
            ->assertDontSee('PRO');
    }

    public function test_authenticated_admin_visiting_beranda_is_redirected_to_admin_dashboard(): void
    {
        $user = (new User)->forceFill([
            'name' => 'Nama Admin',
            'role' => 'admin',
        ]);

        $response = $this->actingAs($user)->get('/beranda');

        $response->assertRedirect(route('admin.dashboard'));
    }
}
