<?php

namespace Tests\Feature;

use App\Models\City;
use Tests\TestCase;

class CityTest extends TestCase
{
    public function test_guest_cannot_create_city()
    {
        $city = City::factory()->make();

        $response = $this->postJson('/api/cities', [$city]);

        $response->assertUnauthorized();
    }

    public function test_authenticade_user_can_create_cities()
    {
        $this->authenticated();

        $city = City::factory()->make(['id' => 1]);

        $response = $this->postJson('/api/cities', $city->toArray());

        $response->assertStatus(201)->assertJson([
            'message' => 'City created successfully',
        ]);

        $this->assertDatabaseHas('cities', [
            'id' => $city->id,
            'name' => $city->name,
        ]);
    }

    public function test_cities_can_be_searchable()
    {
        $this->authenticated();

        City::factory()->create(['name' => 'City One']);
        City::factory()->create(['name' => 'City Two']);

        $response = $this->getJson('/api/cities?search=One');

        $response->assertOk()->assertJson([
            'data' => [
                [
                    'id' => 1,
                    'name' => 'City One',
                ],
            ],
        ])
            ->assertJsonCount(1, 'data')
            ->assertJsonFragment(['name' => 'City One'])
            ->assertJsonMissing(['name' => 'City Two']);
    }

    public function test_list_one_city()
    {
        $this->authenticated();

        $cityOne = City::factory()->create(['name' => 'City One']);
        $cityTwo = City::factory()->create(['name' => 'City Two']);

        $response = $this->getJson("/api/cities/{$cityOne->id}");

        $response->assertOk()
            ->assertJson([
                'data' => [
                    'id' => $cityOne->id,
                    'name' => 'City One',
                ],
            ]);
    }

    public function test_list_all_cities()
    {
        $this->authenticated();

        $response = $this->getJson('/api/cities');

        $response->assertOK()
            ->assertJsonCount(0, 'data');
    }

    public function test_update_city()
    {
        $this->authenticated();

        $city = City::factory()->create([
            'name' => 'City One',
            'state' => 'BA',
            'country' => 'USA',
        ]);

        $reponse = $this->putJson("/api/cities/{$city->id}", [
            'name' => 'City upated',
            'state' => 'SP',
            'country' => 'Brasil',
        ]);

        $reponse->assertOk()
            ->assertJson([
                'data' => [
                    'id' => $city->id,
                    'name' => 'City upated',
                    'state' => 'SP',
                    'country' => 'Brasil',
                ],
            ]);
    }

    public function test_cannot_update_city_to_existing_name()
    {
        $this->authenticated();

        $cityOne = City::factory()->create(['name' => 'City One']);
        $cityTwo = City::factory()->create(['name' => 'City Two']);

        $this->putJson("/api/cities/{$cityTwo->id}", [
            'name' => 'City One',

        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name']);
    }

    public function test_cannot_create_duplicated_city_name()
    {
        $this->authenticated();

        $city = City::factory()->create(['name' => 'Unique city']);

        $this->postJson('/api/cities', [
            'name' => 'Unique city',
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name']);
    }

    public function test_delete_city()
    {
        $this->authenticated();

        $city = City::factory()->create();

        $this->deleteJson("/api/cities/{$city->id}")
            ->assertOk()
            ->assertJson([
                'message' => 'City deleted successfully',
            ]);
    }

    public function test_cannot_delete_non_existing_city()
    {
        $this->authenticated();
        $this->deleteJson('/api/cities/999')
            ->assertNotFound();
    }
}
