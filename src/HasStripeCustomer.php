<?php

namespace Makeable\LaravelStripeObjects;

trait HasStripeCustomer
{
    /**
     * @return StripeCustomer
     */
    public function stripeCustomer()
    {
        return (new StripeObjectRelation($this, StripeCustomer::class, 'owner'))->hasOne();
    }
}
