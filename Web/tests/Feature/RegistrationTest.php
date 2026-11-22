<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_creates_account_and_redirects_guest_to_login(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'Nama Member',
            'email' => 'member@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertGuest();
        $this->assertDatabaseHas('users', [
            'name' => 'Nama Member',
            'email' => 'member@example.com',
            'role' => 'member',
        ]);
    }
}
