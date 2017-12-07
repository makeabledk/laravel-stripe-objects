<?php

namespace Makeable\LaravelStripeObjects;

use Stripe\Account;

class StripeAccount extends StripeObject
{
    /**
     * @var string
     */
    public $objectClass = Account::class;
}
