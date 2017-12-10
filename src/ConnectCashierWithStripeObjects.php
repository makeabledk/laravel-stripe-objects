<?php

namespace Makeable\LaravelStripeObjects;

use Stripe\Customer;

trait ConnectCashierWithStripeObjects
{
    /**
     * @return mixed
     */
    public function getStripeIdAttribute()
    {
        return $this->stripeCustomer()->id;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function setStripeIdAttribute($id)
    {
        return $this->stripeCustomer()->store(Customer::retrieve($id));
    }
}