<?php

namespace Tests\Unit;

use App\Http\Requests\StoreCategoryRequest;
use PHPUnit\Framework\TestCase;

class CategoryUnitTest extends TestCase
{
    public function test_authorize_store_category_request()
    {
        $storeCategoryRequest = new StoreCategoryRequest();

        $this->assertTrue($storeCategoryRequest->authorize());
    }
}
