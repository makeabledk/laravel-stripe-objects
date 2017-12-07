<?php

namespace Makeable\LaravelStripeObjects\Tests\Fakes;

use App\User;
use Makeable\LaravelStripeObjects\Contracts\ProviderContract;
use Makeable\LaravelStripeObjects\Transactable;

class Provider extends User implements ProviderContract
{
    use Transactable;

    /**
     * @var string
     */
    protected $table = 'users';
}
