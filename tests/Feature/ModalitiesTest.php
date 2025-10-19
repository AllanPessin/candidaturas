<?php

namespace Tests\Feature;

use App\Models\Modalities;
use Tests\TestCase;

class ModalitiesTest extends TestCase
{
    public function test_guest_cannot_create_modalities()
    {
        $modalities = Modalities::factory()->make();

        $response = $this->postJson('/api/modalities', [$modalities]);

        $response->assertUnauthorized();
    }

    public function test_authenticade_user_can_create_modalities()
    {
        $this->authenticated();

        $modalities = Modalities::factory()->make(['id' => 1]);

        $response = $this->postJson('/api/modalities', $modalities->toArray());

        $response->assertStatus(201)->assertJson([
            'message' => 'Modality created successfully',
        ]);

        $this->assertDatabaseHas('modalities', [
            'id' => $modalities->id,
            'name' => $modalities->name,
        ]);
    }

    public function test_modalities_can_be_searchable()
    {
        $this->authenticated();

        Modalities::factory()->create(['name' => 'Modalities One']);
        Modalities::factory()->create(['name' => 'Modalities Two']);

        $response = $this->getJson('/api/modalities?search=One');

        $response->assertOk()->assertJson([
            'data' => [
                [
                    'id' => 1,
                    'name' => 'Modalities One',
                ],
            ],
        ])
            ->assertJsonCount(1, 'data')
            ->assertJsonFragment(['name' => 'Modalities One'])
            ->assertJsonMissing(['name' => 'Modalities Two']);
    }

    public function test_list_one_modalities()
    {
        $this->authenticated();

        $modalitiesOne = Modalities::factory()->create(['name' => 'Modalities One']);
        $modalitiesTwo = Modalities::factory()->create(['name' => 'Modalities Two']);

        $response = $this->getJson("/api/modalities/{$modalitiesOne->id}");

        $response->assertOk()
            ->assertJson([
                'data' => [
                    'id' => $modalitiesOne->id,
                    'name' => 'Modalities One',
                ],
            ]);
    }

    public function test_list_all_modalities()
    {
        $this->authenticated();

        Modalities::factory()->count(3)->create();

        $response = $this->getJson('/api/modalities');

        $response->assertOK()
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name'],
                ],
            ]);
    }

    public function test_update_modalities()
    {
        $this->authenticated();

        $modalities = Modalities::factory()->create([
            'name' => 'Modalities One',
        ]);

        $reponse = $this->putJson("/api/modalities/{$modalities->id}", [
            'name' => 'Modalities upated',
        ]);

        $reponse->assertOk()
            ->assertJson([
                'data' => [
                    'id' => $modalities->id,
                    'name' => 'Modalities upated',
                ],
            ]);
    }

    public function test_delete_modalities()
    {
        $this->authenticated();

        $modalities = Modalities::factory()->create();

        $this->deleteJson("/api/modalities/{$modalities->id}")
            ->assertOk()
            ->assertJson([
                'message' => 'Modality deleted successfully',
            ]);
    }

    public function test_cannot_delete_non_existing_modality()
    {
        $this->authenticated();
        $this->deleteJson('/api/cities/999')
            ->assertNotFound();
    }

    public function test_can_delete_many_modalities()
    {
        $this->authenticated();

        $modalities1 = Modalities::factory()->create();
        $modalities2 = Modalities::factory()->create();
        $modalities3 = Modalities::factory()->create();

        $this->deleteJson('/api/modalities/destroy-many', [
            'ids' => [
                $modalities1->id,
                $modalities2->id,
                $modalities3->id,
            ],
        ])
            ->assertJson([
                'message' => 'Modalities deleted successfully',
            ])
            ->assertOk();
    }

    public function test_cannot_bulk_delete_non_existing_ids()
    {
        $this->authenticated();

        $modalities1 = Modalities::factory()->create(['id' => 1]);
        $modalities2 = Modalities::factory()->create(['id' => 2]);
        $modalities3 = Modalities::factory()->create(['id' => 3]);

        $this->deleteJson('/api/modalities/destroy-many', [
            'ids' => [
                4,
                5,
                6,
            ],
        ])
            ->assertUnprocessable()
            ->assertJson([
                'message' => 'Some IDs do not exist in database',
                'error' => [
                    'ids.0' => ['The selected ids.0 is invalid.'],
                    'ids.1' => ['The selected ids.1 is invalid.'],
                    'ids.2' => ['The selected ids.2 is invalid.'],
                ],
            ]);
    }
}
