<?php

namespace Makeable\LaravelStripeObjects;

use Stripe\Customer;

class StripeCustomer extends StripeObject
{
    /**
     * @var string
     */
    public $objectClass = Customer::class;
}
