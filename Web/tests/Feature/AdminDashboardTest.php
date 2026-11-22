<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_renders_statistics(): void
    {
        $admin = User::factory()->create([
            'name' => 'Super Admin',
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertOk()
            ->assertSee('Dashboard Admin')
            ->assertSee('Selamat datang, Super Admin')
            ->assertSee('Total Kamus')
            ->assertSee('Total Member')
            ->assertSee('Langganan Aktif')
            ->assertSee('Transaksi QRIS');
    }
}
