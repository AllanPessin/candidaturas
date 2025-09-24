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
                ],
            ]);

        $this->assertDatabaseHas('statuses', [
            'id' => $status->id,
            'name' => 'Updated Status',
        ]);
    }

    public function test_status_can_be_searchable()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        Status::factory()->create(['name' => 'Active']);
        Status::factory()->create(['name' => 'Inactive']);

        $response = $this->getJson('/api/statuses?search=Active');

        $response->assertOk()
            ->assertJson([
                'data' => [
                    [
                        'id' => 1,
                        'name' => 'Active'
                    ],
                ],
            ])
            ->assertJsonCount(2, 'data');
        // ->assertJsonFragment(['name' => 'Active'])
        // ->assertJsonMissing(['name' => 'Inactive']);
    }

    public function test_list_one_status()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $status = Status::factory()->create();

        $response = $this->getJson("/api/statuses/{$status->id}");

        $response->assertOk()
            ->assertJson([
                'data' => [
                    'id' => $status->id,
                    'name' => $status->name,
                ],
            ]);
    }

    public function test_delete_status()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $status = Status::factory()->create();

        $response = $this->deleteJson("/api/statuses/{$status->id}");

        $response->assertOk()
            ->assertJson([
                'message' => 'Status deleted successfully',
            ]);

        $this->assertDatabaseMissing('statuses', [
            'id' => $status->id,
        ]);
    }
}
