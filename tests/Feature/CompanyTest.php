<?php

namespace Tests\Feature;

use App\Models\Company;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    public function test_guest_cannot_create_company()
    {
        $company = Company::factory()->make();

        $response = $this->postJson('/api/companies', [$company]);

        $response->assertUnauthorized();
    }

    public function test_authenticade_user_can_create_companies()
    {
        $this->authenticated();

        $company = Company::factory()->make(['id' => 1]);

        $response = $this->postJson('/api/companies', $company->toArray());

        $response->assertStatus(201)->assertJson([
            'message' => 'Company created successfully',
        ]);

        $this->assertDatabaseHas('companies', [
            'id' => $company->id,
            'name' => $company->name,
            'website' => $company->website,
            'contact' => $company->contact,
        ]);
    }

    public function test_companies_can_be_searchable()
    {
        $this->authenticated();

        Company::factory()->create(['name' => 'Company One']);
        Company::factory()->create(['name' => 'Company Two']);

        $response = $this->getJson('/api/companies?search=One');

        $response->assertOk()->assertJson([
            'data' => [
                [
                    'id' => 1,
                    'name' => 'Company One',
                ],
            ],
        ])
            ->assertJsonCount(1, 'data')
            ->assertJsonFragment(['name' => 'Company One'])
            ->assertJsonMissing(['name' => 'Company Two']);
    }

    public function test_list_one_company()
    {
        $this->authenticated();

        $companyOne = Company::factory()->create(['name' => 'Company One']);
        $companyTwo = Company::factory()->create(['name' => 'Company Two']);

        $response = $this->getJson("/api/companies/{$companyOne->id}");

        $response->assertOk()
            ->assertJson([
                'data' => [
                    'id' => $companyOne->id,
                    'name' => 'Company One',
                ],
            ]);
    }

    public function test_list_all_companies()
    {
        $this->authenticated();

        Company::factory()->count(3)->create();

        $response = $this->getJson('/api/companies');

        $response->assertOK()
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'website', 'contact'],
                ],
            ]);
    }

    public function test_update_companies()
    {
        $this->authenticated();

        $company = Company::factory()->create([
            'name' => 'Companies One',
        ]);

        $reponse = $this->putJson("/api/companies/{$company->id}", [
            'name' => 'Company upated',
        ]);

        $reponse->assertOk()
            ->assertJson([
                'data' => [
                    'id' => $company->id,
                    'name' => 'Company upated',
                ],
            ]);
    }

    public function test_delete_company()
    {
        $this->authenticated();

        $company = Company::factory()->create();

        $this->deleteJson("/api/companies/{$company->id}")
            ->assertOk()
            ->assertJson([
                'message' => 'Company deleted successfully',
            ]);
    }

    public function test_cannot_delete_non_existing_company()
    {
        $this->authenticated();
        $this->deleteJson('/api/companies/999')
            ->assertNotFound();
    }
}
