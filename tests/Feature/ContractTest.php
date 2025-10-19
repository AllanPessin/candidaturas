<?php

namespace Tests\Feature;

use App\Models\Contract;
use Tests\TestCase;

class ContractTest extends TestCase
{
    public function test_guest_cannot_create_contract()
    {
        $contract = Contract::factory()->make();

        $response = $this->postJson('/api/contracts', [$contract]);

        $response->assertUnauthorized();
    }

    public function test_authenticade_user_can_create_contracts()
    {
        $this->authenticated();

        $contract = Contract::factory()->make(['id' => 1]);

        $response = $this->postJson('/api/contracts', $contract->toArray());

        $response->assertStatus(201)->assertJson([
            'message' => 'Contract created successfully',
        ]);

        $this->assertDatabaseHas('contracts', [
            'id' => $contract->id,
            'name' => $contract->name,
        ]);
    }

    public function test_contracts_can_be_searchable()
    {
        $this->authenticated();

        Contract::factory()->create(['name' => 'Contract One']);
        Contract::factory()->create(['name' => 'Contract Two']);

        $response = $this->getJson('/api/contracts?search=One');

        $response->assertOk()->assertJson([
            'data' => [
                [
                    'id' => 1,
                    'name' => 'Contract One',
                ],
            ],
        ])
            ->assertJsonCount(1, 'data')
            ->assertJsonFragment(['name' => 'Contract One'])
            ->assertJsonMissing(['name' => 'Contract Two']);
    }

    public function test_list_one_contract()
    {
        $this->authenticated();

        $contractOne = Contract::factory()->create(['name' => 'Contract One']);
        $contractTwo = Contract::factory()->create(['name' => 'Contract Two']);

        $response = $this->getJson("/api/contracts/{$contractOne->id}");

        $response->assertOk()
            ->assertJson([
                'data' => [
                    'id' => $contractOne->id,
                    'name' => 'Contract One',
                ],
            ]);
    }

    public function test_list_all_contracts()
    {
        $this->authenticated();

        Contract::factory()->count(3)->create();

        $response = $this->getJson('/api/contracts');

        $response->assertOK()
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name'],
                ],
            ]);
    }

    public function test_update_contract()
    {
        $this->authenticated();

        $contract = Contract::factory()->create([
            'name' => 'Contract One',
        ]);

        $reponse = $this->putJson("/api/contracts/{$contract->id}", [
            'name' => 'Contract upated',
        ]);

        $reponse->assertOk()
            ->assertJson([
                'data' => [
                    'id' => $contract->id,
                    'name' => 'Contract upated',
                ],
            ]);
    }

    public function test_cannot_update_contract_to_existing_name()
    {
        $this->authenticated();

        $contractOne = Contract::factory()->create(['name' => 'Contract One']);
        $contractTwo = Contract::factory()->create(['name' => 'Contract Two']);

        $this->putJson("/api/contracts/{$contractTwo->id}", [
            'name' => 'Contract One',

        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name']);
    }

    public function test_cannot_create_duplicated_contract_name()
    {
        $this->authenticated();

        $contract = Contract::factory()->create(['name' => 'Unique contract']);

        $this->postJson('/api/contracts', [
            'name' => 'Unique contract',
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name']);
    }

    public function test_delete_contract()
    {
        $this->authenticated();

        $contract = Contract::factory()->create();

        $this->deleteJson("/api/contracts/{$contract->id}")
            ->assertOk()
            ->assertJson([
                'message' => 'Contract deleted successfully',
            ]);
    }

    public function test_cannot_delete_non_existing_contract()
    {
        $this->authenticated();
        $this->deleteJson('/api/contracts/999')
            ->assertNotFound();
    }
}
