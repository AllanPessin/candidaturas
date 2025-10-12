<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
    use DatabaseMigrations;

    protected function authenticated()
    {
        $user = $user ?? User::factory()->create();

        Sanctum::actingAs(
            $user,
            ['*']
        );
    }
}
