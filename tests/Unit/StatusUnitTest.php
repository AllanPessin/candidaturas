<?php

namespace Tests\Unit;

use App\Http\Requests\Store\StoreStatusRequest;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\TestCase;

class StatusUnitTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_status_name_required()
    {
        $storeStatusRequest = new StoreStatusRequest();

        $this->assertSame([
            'name' => 'required|string|max:255|unique:statuses,name',
        ], $storeStatusRequest->rules());
    }
}
