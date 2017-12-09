<?php

namespace Makeable\LaravelStripeObjects\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Makeable\LaravelStripeObjects\Tests\Fakes\User;

class DatabaseTestCase extends TestCase
{
    use RefreshDatabase;

    /**
     * @return User
     */
    protected function user()
    {
        return factory(User::class)->create();
    }
}
