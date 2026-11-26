<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_member_can_open_admin_login_page(): void
    {
        $member = User::factory()->create(['role' => 'member']);

        $response = $this->actingAs($member)->get(route('admin.login'));

        $response->assertOk()
            ->assertViewIs('admin.login');
    }

    public function test_authenticated_member_can_sign_in_as_admin(): void
    {
        $member = User::factory()->create(['role' => 'member']);
        $admin = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => 'admin-password',
            'role' => 'admin',
        ]);

        $response = $this->withSession(['url.intended' => route('login')])
            ->actingAs($member)
            ->post(route('admin.login.attempt'), [
                'username' => 'admin@example.com',
                'password' => 'admin-password',
            ]);

        $response->assertRedirect(route('admin.ebooks'));
        $this->assertAuthenticatedAs($admin);
    }

    public function test_guest_requesting_admin_page_is_redirected_to_admin_login(): void
    {
        $response = $this->get(route('admin.ebooks'));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_authenticated_admin_is_redirected_from_login_page_to_manage_ebooks(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('admin.login'));

        $response->assertRedirect(route('admin.ebooks'));
    }
}
