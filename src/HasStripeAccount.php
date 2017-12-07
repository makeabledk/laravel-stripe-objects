<?php

namespace Makeable\LaravelStripeObjects;

trait HasStripeAccount
{
    /**
     * @return StripeAccount
     */
    public function stripeAccount()
    {
        return (new StripeObjectRelation($this, StripeAccount::class, 'owner'))->hasOne();
    }
}
