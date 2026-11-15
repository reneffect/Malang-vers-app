<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class NavbarTest extends TestCase
{
    public function test_guest_sees_login_and_registration_links(): void
    {
        $response = $this->get('/kamus');

        $response->assertOk()
            ->assertSee('Masuk')
            ->assertSee('Daftar');
    }

    public function test_authenticated_member_sees_their_name_linked_to_member_home(): void
    {
        $user = (new User)->forceFill([
            'name' => 'Nama Member',
            'role' => 'member',
        ]);

        $response = $this->actingAs($user)->get('/kamus');

        $response->assertOk()
            ->assertSee('Nama Member')
            ->assertSee('href="'.route('member.member-home').'"', false)
            ->assertDontSee('href="'.route('login').'"', false);
    }

    public function test_authenticated_admin_sees_their_name_linked_to_admin_dashboard(): void
    {
        $user = (new User)->forceFill([
            'name' => 'Nama Admin',
            'role' => 'admin',
        ]);

        $response = $this->actingAs($user)->get('/kamus');

        $response->assertOk()
            ->assertSee('Nama Admin')
            ->assertSee('href="'.route('admin.dashboard').'"', false)
            ->assertDontSee('href="'.route('login').'"', false);
    }
}
