<?php

namespace Tests\Feature;

use App\Models\DictionaryEntry;
use App\Models\GuestUsage;
use App\Models\Membership;
use App\Models\MembershipTier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WalikanTranslationTest extends TestCase
{
    use RefreshDatabase;

    public function test_translation_endpoint_converts_indonesian_to_walikan(): void
    {
        $response = $this->postJson(route('translate'), [
            'text' => 'Halo',
            'direction' => 'id_to_walikan',
        ]);

        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('translated', 'Olah')
            ->assertJsonPath('remaining', 9);

        $this->assertDatabaseHas('translation_histories', [
            'original_text' => 'Halo',
            'translated_text' => 'Olah',
            'direction' => 'id_to_walikan',
        ]);
    }

    public function test_translation_endpoint_converts_walikan_to_indonesian(): void
    {
        $response = $this->postJson(route('translate'), [
            'text' => 'Olah',
            'direction' => 'walikan_to_id',
        ]);

        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('translated', 'Halo')
            ->assertJsonPath('remaining', 9);

        $this->assertDatabaseHas('translation_histories', [
            'original_text' => 'Olah',
            'translated_text' => 'Halo',
            'direction' => 'walikan_to_id',
        ]);
    }

    public function test_popular_words_are_ranked_across_guest_and_member_translations(): void
    {
        MembershipTier::create([
            'name' => 'Paket Gratis',
            'slug' => 'gratis',
            'daily_credits' => 100,
            'credits_per_word' => 5,
        ]);
        DictionaryEntry::create([
            'indonesian_word' => 'halo',
            'walikan_word' => 'olah',
            'javanese_word' => 'halo',
        ]);
        $user = User::factory()->create([
            'role' => 'member',
            'daily_credit' => 100,
            'credit_reset_date' => now('Asia/Jakarta')->toDateString(),
        ]);

        $guestResponse = $this->postJson(route('translate'), [
            'text' => 'Halo Halo',
            'direction' => 'id_to_walikan',
        ]);
        $memberResponse = $this->actingAs($user)->postJson(route('translate'), [
            'text' => 'Olah',
            'direction' => 'walikan_to_id',
        ]);

        $guestResponse->assertOk();
        $memberResponse->assertOk();
        $popularResponse = $this->getJson(route('popular.phrases'));

        $popularResponse->assertOk()
            ->assertJsonPath('0.indonesian', 'Halo')
            ->assertJsonPath('0.walikan', 'Olah')
            ->assertJsonPath('0.usage_count', 3);
        $this->assertDatabaseHas('translation_phrase_usages', [
            'indonesian_word' => 'halo',
            'walikan_word' => 'olah',
        ]);
    }

    public function test_guest_cannot_use_more_than_ten_lifetime_tokens(): void
    {
        GuestUsage::create([
            'guest_token' => 'existing-fingerprint',
            'ip_address' => '203.0.113.10',
            'device_fingerprint' => 'existing-fingerprint',
            'usage_count' => 10,
        ]);

        $response = $this->withHeaders([
            'X-Forwarded-For' => '203.0.113.10',
        ])->postJson(route('translate'), [
            'text' => 'Halo',
            'direction' => 'id_to_walikan',
            'device_fingerprint' => 'new-browser-fingerprint',
        ]);

        $response->assertTooManyRequests()
            ->assertJsonPath('code', 'LIMIT_EXCEEDED')
            ->assertJsonPath('quota.remaining', 0)
            ->assertJsonPath('quota.max', 10);

        $this->assertDatabaseHas('guest_usages', [
            'guest_token' => 'existing-fingerprint',
            'usage_count' => 10,
        ]);
    }

    public function test_standard_member_translation_uses_database_quota_and_persists_the_deduction(): void
    {
        $tier = MembershipTier::create([
            'name' => 'Paket Standar',
            'slug' => 'standar',
            'daily_credits' => 1000,
            'credits_per_word' => 5,
        ]);
        $user = User::factory()->create([
            'daily_credit' => 1000,
            'credit_reset_date' => now('Asia/Jakarta')->toDateString(),
        ]);
        Membership::create([
            'user_id' => $user->id,
            'membership_tier_id' => $tier->id_membership_tier,
            'started_at' => now(),
            'ends_at' => now()->addMonth(),
            'status' => 'active',
        ]);

        $response = $this->actingAs($user)->postJson(route('translate'), [
            'text' => 'Olah',
            'direction' => 'walikan_to_id',
        ]);

        $response->assertOk()
            ->assertJsonPath('quota.balance', 995)
            ->assertJsonPath('quota.max', 1000)
            ->assertJsonPath('quota.credits_per_word', 5);

        $homeResponse = $this->actingAs($user)->get('/member-home');

        $homeResponse->assertOk()
            ->assertSee('Credit: 995 / 1000');
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'daily_credit' => 995,
        ]);
    }

    public function test_free_member_translation_clamps_stale_standard_credits_to_the_database_limit(): void
    {
        $tier = MembershipTier::create([
            'name' => 'Paket Gratis',
            'slug' => 'gratis',
            'daily_credits' => 100,
            'credits_per_word' => 5,
        ]);
        $user = User::factory()->create([
            'daily_credit' => 1000,
            'credit_reset_date' => now('Asia/Jakarta')->toDateString(),
        ]);
        Membership::create([
            'user_id' => $user->id,
            'membership_tier_id' => $tier->id_membership_tier,
            'started_at' => now(),
            'ends_at' => null,
            'status' => 'active',
        ]);

        $response = $this->actingAs($user)->postJson(route('translate'), [
            'text' => 'Olah',
            'direction' => 'walikan_to_id',
        ]);

        $response->assertOk()
            ->assertJsonPath('quota.balance', 95)
            ->assertJsonPath('quota.max', 100);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'daily_credit' => 95,
        ]);
    }
}
