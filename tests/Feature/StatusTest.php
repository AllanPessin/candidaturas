<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class StatusTest extends TestCase
{
    public function test_guest_cannot_create_status()
    {
        $response = $this->postJson('/api/statuses', [
            'name' => 'New Status',
        ]);

        $response->assertUnauthorized();
    }

    public function test_authenticated_user_can_create_statuses()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $response = $this->postJson('/api/statuses', [
            'name' => 'New Status'
        ]);

        $response->assertCreated();
    }
}
