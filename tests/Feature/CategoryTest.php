<?php

namespace Tests\Feature;

use App\Models\Category;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    public function test_guest_cannot_create_category()
    {
        $category = Category::factory()->make();

        $this->postJson('/api/categories', [
            $category,
        ])
            ->assertUnauthorized();
    }

    public function test_authenticated_user_can_create_categories()
    {
        $this->authenticated();

        $category = Category::factory()->make();

        $this->postJson('/api/categories', $category->toArray())
            ->assertCreated()
            ->assertJson([
                'message' => 'Category created successfully',
            ]);

        $this->assertDatabaseHas('categories', [
            'name' => $category->name,
            'slug' => $category->slug,
        ]);
    }

    public function test_list_categories()
    {
        $this->authenticated();

        Category::factory()->count(3)->create();

        $this->getJson('/api/categories')
            ->assertOk()
            ->assertJsonCount(3, 'data')
            ->assertJson([
                'data' => [
                    ['id' => 1],
                    ['id' => 2],
                    ['id' => 3],
                ],
            ]);
    }

    public function test_can_update_category()
    {
        $this->authenticated();

        $category = Category::factory()->create([
            'name' => 'New category',
        ]);

        $this->putJson("/api/categories/{$category->slug}", [
            'name' => 'Updated category',
            'slug' => 'updated-category',
        ])
            ->assertOk()
            ->assertJson([
                'data' => [
                    'id' => $category->id,
                    'name' => 'Updated category',
                    'slug' => 'updated-category',
                ],
            ]);

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Updated category',
            'slug' => 'updated-category',
        ]);
    }

    public function test_category_can_be_searchable()
    {
        $this->authenticated();

        Category::factory()->create(['name' => 'Category one']);
        Category::factory()->create(['name' => 'Category two']);

        $this->getJson('/api/categories?search=category')
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJson([
                'data' => [
                    ['name' => 'Category one'],
                ],
            ]);
    }

    public function test_list_one_category()
    {
        $this->authenticated();

        $category = Category::factory()->create();

        $this->getJson("/api/categories/{$category->slug}")
            ->assertOK()
            ->assertJson([
                'data' => [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                ],
            ]);
    }

    public function test_delete_category()
    {
        $this->authenticated();

        $category = Category::factory()->create();

        $this->deleteJson("/api/categories/{$category->slug}")
            ->assertOk()
            ->assertJson([
                'message' => 'Category deleted successfully',
            ]);

        $this->assertDatabaseMissing('categories', [
            'slug' => $category->slug
        ]);
    }

    public function test_canoot_create_duplicated_category_slug()
    {
        $this->authenticated();

        $category = Category::factory()->create();

        $this->postJson('/api/categories', [
            'name' => 'Another category',
            'slug' => $category->slug,
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['slug']);
    }

    public function test_cannot_update_category_to_existing_slug()
    {
        $this->authenticated();

        $category1 = Category::factory()->create();
        $category2 = Category::factory()->create();

        $this->putJson("/api/categories/{$category2->slug}", [
            'name' => 'Updated name',
            'slug' => $category1->slug,
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['slug']);
    }

    public function test_cannot_delete_non_existing_status()
    {
        $this->authenticated();

        $this->deleteJson('/api/categories/non-existing-slug')
            ->assertNotFound();
    }
}
