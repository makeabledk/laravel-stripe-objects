<?php

namespace Makeable\LaravelStripeObjects\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Makeable\LaravelStripeObjects\Escrow;
use Makeable\LaravelStripeObjects\Repositories\EscrowRepository;
use Makeable\LaravelStripeObjects\Tests\Fakes\User;
use Makeable\LaravelStripeObjects\Tests\Fakes\Product;
use Makeable\LaravelStripeObjects\Tests\Fakes\Provider;

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
