<?php

namespace Tests\Feature;

use App\Models\Membership;
use App\Models\MembershipTier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUsersTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_user_directory_shows_the_default_profile_on_the_right(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create([
            'name' => 'Profil Default',
            'email' => 'profil-default@example.com',
            'phone' => '081234567890',
            'kota' => 'Malang',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.users'));

        $response->assertOk()
            ->assertViewIs('admin.users')
            ->assertViewHas('selectedUser', fn (User $selectedUser): bool => $selectedUser->is($user))
            ->assertSee('id="profile-detail"', false)
            ->assertSee('Detail Informasi Pengguna')
            ->assertSee('Profil Default')
            ->assertSee('081234567890')
            ->assertSee('Malang')
            ->assertSee('Belum memiliki membership aktif.');
    }

    public function test_admin_can_select_a_user_profile_and_see_their_active_membership(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $selectedUser = User::factory()->create([
            'name' => 'Profil Terpilih',
            'email' => 'terpilih@example.com',
        ]);
        User::factory()->create([
            'name' => 'Pengguna Terbaru',
            'email' => 'terbaru@example.com',
        ]);

        $tier = MembershipTier::create([
            'name' => 'Paket Premium',
            'duration_days' => 30,
            'price' => 50000,
            'is_active' => true,
        ]);

        $membership = new Membership;
        $membership->forceFill([
            'user_id' => $selectedUser->id,
            'membership_tier_id' => $tier->id_membership_tier,
            'started_at' => now(),
            'ends_at' => now()->addDays(30),
            'status' => 'active',
        ])->save();

        $response = $this->actingAs($admin)->get(route('admin.users', ['user' => $selectedUser->id]));

        $response->assertOk()
            ->assertViewHas('selectedUser', fn (User $user): bool => $user->is($selectedUser))
            ->assertSee('Profil Terpilih')
            ->assertSee('Paket Premium')
            ->assertSee('Akses membership aktif')
            ->assertSee(route('admin.users', ['user' => $selectedUser->id]).'#profile-detail', false);
    }
}
