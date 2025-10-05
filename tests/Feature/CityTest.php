<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
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
                    'name' => 'City One'
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
                    'name' => 'City One'
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
}
