<?php

namespace Makeable\LaravelStripeObjects\Tests\Fakes;

use Makeable\LaravelCurrencies\Amount;
use Makeable\LaravelStripeObjects\Contracts\PaymentGatewayContract;
use Makeable\LaravelStripeObjects\Contracts\RefundableContract;
use Makeable\LaravelStripeObjects\Contracts\TransferSourceContract;

class TransferSource implements TransferSourceContract
{
    /**
     * @return RefundableContract
     */
    public function refund()
    {
        return app(PaymentGatewayContract::class)->handle();
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public static function findOrFail($id)
    {
        return new static();
    }

    /**
     * @return Amount
     */
    public function getAmount()
    {
        return new Amount(100);
    }

    /**
     * @return mixed
     */
    public function getKey()
    {
        return rand();
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [];
    }
}
