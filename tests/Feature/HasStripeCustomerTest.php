<?php

namespace Makeable\LaravelStripeObjects\Tests\Feature;

use Makeable\LaravelCurrencies\Amount;
use Makeable\LaravelStripeObjects\StripeCustomer;
use Makeable\LaravelStripeObjects\Tests\DatabaseTestCase;
use Makeable\LaravelStripeObjects\Tests\Fakes\User;
use Makeable\LaravelStripeObjects\Transaction;

class HasStripeCustomerTest extends DatabaseTestCase
{
    /** @test **/
    function it_returns_a_none_existing_stripe_customer_as_default()
    {
        $this->assertInstanceOf(StripeCustomer::class, $customer = $this->user()->stripeCustomer());
        $this->assertFalse($customer->exists);
    }
}
