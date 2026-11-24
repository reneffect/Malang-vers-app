<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_page_shows_profile_drawer_for_signed_in_admin(): void
    {
        $admin = User::factory()->create([
            'name' => 'Super Admin',
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.ebooks'));

        $response->assertOk()
            ->assertSee('Kelola Kamus Boso Walikan')
            ->assertSee('id="adminProfileTrigger"', false)
            ->assertSee('id="adminProfilePanel"', false)
            ->assertSee('Detail Profil Admin')
            ->assertSee($admin->email)
            ->assertSee('action="'.route('admin.logout').'"', false)
            ->assertSee('Administrator');
    }
}
