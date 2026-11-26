<?php

namespace Tests\Feature;

use App\Models\Membership;
use App\Models\MembershipTier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemberDefaultMembershipTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_assigns_the_free_membership(): void
    {
        $freeTier = $this->createTier('gratis');

        $response = $this->post(route('register'), [
            'name' => 'Member Baru',
            'email' => 'member-baru@example.test',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $response->assertRedirect(route('login'));

        $user = User::query()->where('email', 'member-baru@example.test')->firstOrFail();

        $this->assertDatabaseHas('memberships', [
            'user_id' => $user->id,
            'membership_tier_id' => $freeTier->getKey(),
            'status' => 'active',
            'ends_at' => null,
        ]);
    }

    public function test_existing_member_gets_free_membership_when_logging_in_without_an_active_plan(): void
    {
        $freeTier = $this->createTier('gratis');
        $user = User::factory()->create(['password' => 'password']);

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('member.member-home'));

        $this->assertDatabaseHas('memberships', [
            'user_id' => $user->id,
            'membership_tier_id' => $freeTier->getKey(),
            'status' => 'active',
            'ends_at' => null,
        ]);
    }

    public function test_logging_in_does_not_replace_an_active_paid_membership_with_free(): void
    {
        $this->createTier('gratis');
        $standardTier = $this->createTier('standar');
        $user = User::factory()->create(['password' => 'password']);

        Membership::create([
            'user_id' => $user->id,
            'membership_tier_id' => $standardTier->getKey(),
            'started_at' => now(),
            'ends_at' => now()->addMonth(),
            'status' => 'active',
        ]);

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('member.member-home'));
        $this->assertDatabaseCount('memberships', 1);
        $this->assertSame('standar', $user->fresh()->getCurrentPlan()?->slug);
    }

    public function test_firebase_member_login_assigns_the_free_membership(): void
    {
        $freeTier = $this->createTier('gratis');

        $response = $this->postJson(route('firebase.callback'), [
            'name' => 'Google Member',
            'email' => 'google-member@example.test',
            'google_id' => 'google-member-id',
        ]);

        $response->assertOk()
            ->assertJsonPath('success', true);

        $user = User::query()->where('email', 'google-member@example.test')->firstOrFail();

        $this->assertDatabaseHas('memberships', [
            'user_id' => $user->id,
            'membership_tier_id' => $freeTier->getKey(),
            'status' => 'active',
            'ends_at' => null,
        ]);
    }

    private function createTier(string $slug): MembershipTier
    {
        return MembershipTier::create([
            'name' => 'Paket '.ucfirst($slug),
            'slug' => $slug,
            'duration_days' => $slug === 'gratis' ? 0 : 30,
            'price' => $slug === 'gratis' ? 0 : 19000,
            'monthly_price' => $slug === 'gratis' ? 0 : 19000,
            'yearly_price' => $slug === 'gratis' ? 0 : 190000,
            'daily_credits' => $slug === 'premium' ? null : ($slug === 'standar' ? 1000 : 100),
            'credits_per_word' => $slug === 'premium' ? 0 : 5,
            'is_unlimited_translate' => $slug === 'premium',
            'preview_pages' => $slug === 'premium' ? 0 : 4,
            'is_active' => true,
        ]);
    }
}
