<?php

namespace Makeable\LaravelStripeObjects\Tests\Feature;

use Makeable\LaravelStripeObjects\StripeCustomer;
use Makeable\LaravelStripeObjects\Tests\DatabaseTestCase;
use Makeable\LaravelStripeObjects\Tests\Fakes\User;
use Stripe\Customer;

class HasStripeCustomerTest extends DatabaseTestCase
{
    /** @test **/
    public function it_returns_a_none_existing_stripe_customer_as_default()
    {
        $this->assertInstanceOf(StripeCustomer::class, $customer = $this->user()->stripeCustomer());
        $this->assertFalse($customer->exists);
    }

    /** @test **/
    public function it_attaches_stripe_customer_when_stored()
    {
        $user = $this->user();
        $customer = $user->stripeCustomer()->store(new Customer('cu_123'));

        $this->assertTrue($user->stripeCustomer()->is($customer));
        $this->assertTrue($customer->relations(User::class)->first()->is($user));
    }
}
