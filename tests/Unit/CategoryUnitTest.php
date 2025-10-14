<?php

namespace Tests\Unit;

use App\Http\Requests\Store\StoreCategoryRequest;
use App\Http\Requests\Update\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Support\Str;
use PHPUnit\Framework\TestCase;

class CategoryUnitTest extends TestCase
{
    public function test_authorize_store_category_request()
    {
        $storeCategoryRequest = new StoreCategoryRequest;

        $this->assertTrue($storeCategoryRequest->authorize());
    }

    public function test_returns_slug_as_route_key_name()
    {
        $category = new Category;

        $this->assertEquals('slug', $category->getRouteKeyName());
    }

    public function test_converts_slug_to_a_url_friendly_format_before_save()
    {
        $updateCategoryRequest = new UpdateCategoryRequest;

        $updateCategoryRequest->merge([
            'slug' => 'This is a test slug',
        ]);

        $updateCategoryRequest->prepareForValidation();

        $this->assertEquals(Str::slug('This is a test slug'), $updateCategoryRequest->slug);
    }
}
