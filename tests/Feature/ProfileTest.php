<?php

namespace Tests\Feature;

use App\Models\Membership;
use App\Models\MembershipTier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_from_profile_page(): void
    {
        $response = $this->get(route('profile.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_open_their_profile_page(): void
    {
        $user = (new User)->forceFill([
            'name' => 'Nama Member',
            'email' => 'member@example.com',
            'role' => 'member',
            'xp' => 0,
            'level' => 1,
        ]);

        $response = $this->actingAs($user)->get(route('profile.index'));

        $response->assertOk()
            ->assertSee('Pengaturan Profil Member')
            ->assertSee('Nama Member')
            ->assertSee('Informasi langganan belum tersedia')
            ->assertSee('Batal')
            ->assertSee('Simpan Perubahan')
            ->assertSee(route('profile.update'), false);
    }

    public function test_profile_sidebar_displays_the_active_membership_from_database(): void
    {
        $tier = MembershipTier::create([
            'name' => 'Paket Premium',
            'slug' => 'premium',
            'duration_days' => 30,
            'monthly_price' => 49000,
            'yearly_price' => 490000,
            'daily_credits' => 1000,
            'is_unlimited_translate' => true,
            'is_active' => true,
        ]);
        $user = User::factory()->create();
        $endsAt = now()->addDays(30);

        Membership::create([
            'user_id' => $user->id,
            'membership_tier_id' => $tier->getKey(),
            'started_at' => now(),
            'ends_at' => $endsAt,
            'status' => 'active',
            'billing_cycle' => 'monthly',
            'payment_reference' => 'YOV4-PRO-001',
        ]);

        $response = $this->actingAs($user)->get(route('profile.index'));

        $response->assertOk()
            ->assertSee('Member Premium (Aktif s/d '.$endsAt->format('d M Y').')')
            ->assertSee('Paket Premium')
            ->assertSee('Akses penuh semua E-Book dan fitur penerjemah tanpa batas.')
            ->assertSee('QRIS Otomatis');
    }

    public function test_authenticated_user_can_update_their_profile(): void
    {
        $user = User::factory()->create([
            'name' => 'Nama Lama',
            'email' => 'lama@example.com',
        ]);

        $response = $this->actingAs($user)->put(route('profile.update'), [
            'name' => 'Nama Baru',
            'email' => 'baru@example.com',
            'phone' => '081234567890',
            'tanggal_lahir' => '2000-01-31',
            'kota' => 'Malang',
            'bio' => 'Pengguna MulangVerse.',
            'alias_osob' => 'Sam Kera',
        ]);

        $response->assertRedirect(route('profile.index'))
            ->assertSessionHas('success', 'Profil berhasil diperbarui.');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Nama Baru',
            'email' => 'baru@example.com',
            'phone' => '081234567890',
            'kota' => 'Malang',
            'bio' => 'Pengguna MulangVerse.',
            'alias_osob' => 'Sam Kera',
        ]);
    }

    public function test_authenticated_user_can_update_their_password(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('Password Lama 123'),
        ]);

        $response = $this->actingAs($user)->post(route('profile.password'), [
            'current_password' => 'Password Lama 123',
            'password' => 'Password Baru 456',
            'password_confirmation' => 'Password Baru 456',
        ]);

        $response->assertRedirect(route('profile.index'))
            ->assertSessionHas('success', 'Kata sandi berhasil diperbarui.');

        $this->assertTrue(Hash::check('Password Baru 456', $user->fresh()->password));
    }

    public function test_authenticated_user_can_upload_their_avatar(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson(route('profile.avatar'), [
            'avatar' => UploadedFile::fake()->createWithContent(
                'avatar.png',
                base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M/wHwAF/gJ/r6nVvAAAAABJRU5ErkJggg=='),
            ),
        ]);

        $response->assertOk()
            ->assertJson([
                'success' => true,
            ]);

        $avatar = $user->fresh()->avatar;
        $this->assertNotNull($avatar);
        Storage::disk('public')->assertExists($avatar);

        $profileResponse = $this->actingAs($user)->get(route('profile.index'));
        $profileResponse->assertOk()
            ->assertSee(asset('storage/'.$avatar), false);
    }
}
