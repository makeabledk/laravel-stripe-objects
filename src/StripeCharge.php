<?php

namespace Makeable\LaravelStripeObjects;

use Stripe\Charge;

class StripeCharge extends StripeObject
{
    /**
     * @var string
     */
    public $objectClass = Charge::class;
}
