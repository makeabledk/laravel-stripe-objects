<?php

namespace Makeable\LaravelStripeObjects;

use Stripe\Refund;

class StripeRefund extends StripeObject
{
    /**
     * @var string
     */
    public $objectClass = Refund::class;
}
