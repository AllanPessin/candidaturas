<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_user_can_login_with_corret_credentials(): void
    {
        $password = 'password';

        $user = User::factory()->create([
            'password' => bcrypt($password),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertOk();
    }

    public function test_user_cannot_login_with_wrong_credential()
    {
        $password = 'password';

        $user = User::factory()->create([
            'password' => bcrypt('anotherpassword'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertStatus(401);
    }
}
