<?php

namespace Tests\Unit;

use App\Http\Requests\Store\StoreStatusRequest;
use PHPUnit\Framework\TestCase;

class StatusUnitTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_store_status()
    {
        $storeStatusRequest = new StoreStatusRequest;

        $this->assertSame([
            'name' => 'required|string|max:255|unique:statuses,name',
        ], $storeStatusRequest->rules());
    }

    public function test_update_status()
    {
        $updateStatusRequest = new StoreStatusRequest;

        $this->assertSame([
            'name' => 'required|string|max:255|unique:statuses,name',
        ], $updateStatusRequest->rules());
    }
}
