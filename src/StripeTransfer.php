<?php

namespace Makeable\LaravelStripeObjects;

use Stripe\Transfer;

class StripeTransfer extends StripeObject
{
    /**
     * @var string
     */
    public $objectClass = Transfer::class;
}
