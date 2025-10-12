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

        $this->assertDataBaseHas('categories', [
            'name' => $category->name,
            'slug' => $category->slug,
        ]);
    }
}
