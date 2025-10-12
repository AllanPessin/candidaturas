<?php

namespace Tests\Unit;

use App\Http\Requests\Store\StoreCityRequest;
use App\Http\Requests\Update\UpdateCityRequest;
use PHPUnit\Framework\TestCase;

class CityUnitTest extends TestCase
{
    public function test_store_city(): void
    {
        $storeCityReqeust = new StoreCityRequest;

        $this->assertSame([
            'name' => 'required|string|max:255|unique:cities,name',
        ], $storeCityReqeust->rules());
    }

    public function test_update_city()
    {
        $updateCityRequest = new UpdateCityRequest;

        $this->assertSame([
            'name' => 'required|string|max:255|unique:cities,name',
        ], $updateCityRequest->rules());
    }

    public function test_authorize_update_returns_true()
    {
        $updateCityRequest = new UpdateCityRequest;
        $this->assertTrue($updateCityRequest->authorize());
    }
}
