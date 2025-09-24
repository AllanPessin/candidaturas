<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class CityUnit extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_store_city(): void
    {
        $storeCityReqeust = '';

        $this->assertSame([
            'name' => 'required|string|max:255|unique:cities,name',
        ], $storeCityReqeust->rules());
    }
}
