<?php

namespace Tests\Feature;

use App\Models\Status;
use App\Models\User;
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
            'name' => 'New Status',
        ]);

        $response->assertCreated();
    }

    public function test_list_statuses()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $status = Status::factory()->create();

        $response = $this->getJson('/api/statuses');

        $response->assertOk()
            ->assertJson([
                'data' => [
                    [
                        'id' => $status->id,
                        'name' => $status->name,
                    ],
                ],
            ]);
    }

    public function test_authenticated_user_can_update_status()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $status = Status::factory()->create(['name' => 'New Status']);

        $response = $this->putJson("/api/statuses/{$status->id}", [
            'name' => 'Updated Status',
        ]);

        $response->assertOk()
            ->assertJson([
                'data' => [
                    'id' => $status->id,
                    'name' => 'Updated Status',
                ]
            ]);

        $this->assertDatabaseHas('statuses', [
            'id' => $status->id,
            'name' => 'Updated Status',
        ]);
    }
}
