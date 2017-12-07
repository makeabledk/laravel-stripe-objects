<?php

namespace Makeable\LaravelStripeObjects;

use Stripe\TransferReversal;

class StripeTransferReversal extends StripeObject
{
    /**
     * @var string
     */
    public $objectClass = TransferReversal::class;
}
