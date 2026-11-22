<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class MemberHomeTest extends TestCase
{
    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get('/member-home');

        $response->assertRedirect(route('login'));
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
            ->assertSee('© 2026 MalangVerse');
    }
}
