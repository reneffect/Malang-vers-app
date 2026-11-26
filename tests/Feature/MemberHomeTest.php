<?php

namespace Tests\Feature;

use App\Models\Membership;
use App\Models\MembershipTier;
use App\Models\TranslationHistory;
use App\Models\TranslationPhraseUsage;
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
        MembershipTier::create([
            'name' => 'Paket Gratis',
            'slug' => 'gratis',
            'daily_credits' => 100,
        ]);
        $user = User::factory()->create([
            'name' => 'Nama Member',
            'role' => 'member',
        ]);
        $history = TranslationHistory::create([
            'original_text' => 'Halo, apa kabar? Semoga sehat selalu!',
            'translated_text' => 'Olah, apu rabak? agomeh tahes ulalas!',
            'direction' => 'walikan_to_id',
            'user_id' => $user->id,
        ]);
        TranslationPhraseUsage::create([
            'translation_history_id' => $history->id,
            'indonesian_word' => 'halo',
            'walikan_word' => 'olah',
        ]);

        $response = $this->actingAs($user)->get('/member-home');

        $response->assertOk()
            ->assertSee('Nama Member')
            ->assertSee('Halo, apa kabar? Semoga sehat selalu!')
            ->assertSee('Olah, apu rabak? agomeh tahes ulalas!')
            ->assertSee('Halo')
            ->assertSee('Olah')
            ->assertSee('Credit: 100 / 100')
            ->assertSee('Penerjemah Boso Walikan GRATIS')
            ->assertDontSee('<i class="fas fa-crown text-amber-400"></i>', false)
            ->assertSee('© 2026 MalangVerse');
    }

    public function test_member_home_only_displays_the_current_users_latest_four_translations(): void
    {
        MembershipTier::create([
            'name' => 'Paket Gratis',
            'slug' => 'gratis',
            'daily_credits' => 100,
        ]);
        $user = User::factory()->create(['role' => 'member']);
        $otherUser = User::factory()->create(['role' => 'member']);
        $baseTime = now()->startOfSecond();

        for ($number = 1; $number <= 5; $number++) {
            $timestamp = $baseTime->copy()->addSeconds($number);
            TranslationHistory::create([
                'original_text' => "Riwayat member {$number}",
                'translated_text' => "Hasil member {$number}",
                'direction' => 'walikan_to_id',
                'user_id' => $user->id,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ]);
        }

        TranslationHistory::create([
            'original_text' => 'Riwayat milik pengguna lain',
            'translated_text' => 'Hasil privat',
            'direction' => 'walikan_to_id',
            'user_id' => $otherUser->id,
            'created_at' => $baseTime->copy()->addMinutes(1),
            'updated_at' => $baseTime->copy()->addMinutes(1),
        ]);

        $response = $this->actingAs($user)->get('/member-home');

        $response->assertOk()
            ->assertSeeInOrder([
                'Riwayat member 5',
                'Riwayat member 4',
                'Riwayat member 3',
                'Riwayat member 2',
            ])
            ->assertDontSee('Riwayat member 1')
            ->assertDontSee('Riwayat milik pengguna lain')
            ->assertDontSee('Hasil privat');
    }

    public function test_active_membership_shows_its_tier_in_the_hero_badge(): void
    {
        $user = User::factory()->create([
            'role' => 'member',
        ]);
        $tier = MembershipTier::create([
            'name' => 'Member Premium',
            'slug' => 'premium',
            'is_unlimited_translate' => true,
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
            ->assertSee('UNLIMITED')
            ->assertSee('Penerjemah Boso Walikan PRO')
            ->assertSee('Credit: Tanpa Batas');
    }

    public function test_pending_membership_does_not_show_a_tier_badge(): void
    {
        $user = User::factory()->create([
            'role' => 'member',
        ]);
        MembershipTier::create([
            'name' => 'Paket Gratis',
            'slug' => 'gratis',
            'daily_credits' => 100,
        ]);
        $tier = MembershipTier::create([
            'name' => 'Member Premium',
            'slug' => 'premium',
            'is_unlimited_translate' => true,
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
            ->assertDontSee('UNLIMITED')
            ->assertSee('Credit: 100 / 100')
            ->assertSee('Penerjemah Boso Walikan GRATIS');
    }

    public function test_standard_member_home_uses_the_credit_balance_and_limit_from_the_database(): void
    {
        $tier = MembershipTier::create([
            'name' => 'Paket Standar',
            'slug' => 'standar',
            'daily_credits' => 1000,
            'credits_per_word' => 5,
        ]);
        $user = User::factory()->create([
            'role' => 'member',
            'daily_credit' => 875,
            'credit_reset_date' => now('Asia/Jakarta')->toDateString(),
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
            ->assertSee('Credit: 875 / 1000')
            ->assertSee('Penerjemah Boso Walikan STANDAR')
            ->assertSee('1000 KREDIT/HARI');
    }

    public function test_member_can_fetch_all_translation_history_via_api(): void
    {
        $user = User::factory()->create(['role' => 'member']);

        for ($i = 1; $i <= 5; $i++) {
            TranslationHistory::create([
                'original_text' => "Original {$i}",
                'translated_text' => "Translated {$i}",
                'direction' => 'walikan_to_id',
                'user_id' => $user->id,
            ]);
        }

        $response = $this->actingAs($user)->getJson(route('member.translation-history'));

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'count' => 5,
            ])
            ->assertJsonCount(5, 'data');
    }
}
