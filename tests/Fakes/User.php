<?php

namespace Makeable\LaravelStripeObjects\Tests\Fakes;

use Makeable\LaravelStripeObjects\HasStripeAccount;
use Makeable\LaravelStripeObjects\HasStripeCustomer;

class User extends \App\User
{
    use HasStripeAccount,
        HasStripeCustomer;

    /**
     * @var string
     */
    protected $table = 'users';
}
