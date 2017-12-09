<?php

namespace Makeable\LaravelStripeObjects\Tests\Feature;

use Makeable\LaravelStripeObjects\StripeObject;
use Makeable\LaravelStripeObjects\Tests\DatabaseTestCase;
use Stripe\Customer;

class StripeObjectTest extends DatabaseTestCase
{
    /** @test **/
    public function it_can_store_a_stripe_object()
    {
        $this->assertEquals(1, StripeObject::createFromObject(new Customer(1))->id);

        $this->assertTrue(StripeObject::createFromObject(new Customer(2))->exists);

        $this->assertEquals(3, (new StripeObject)->store(new Customer(3))->id);
    }

    /** @test **/
    public function it_does_not_apply_global_type_scope_on_stripe_object_queries()
    {
        StripeObject::createFromObject(new Customer(1));

        $this->assertInstanceOf(StripeObject::class, StripeObject::find(1));
    }
}
