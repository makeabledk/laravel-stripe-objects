<?php

namespace Makeable\LaravelStripeObjects\Tests\Feature;

use Makeable\LaravelStripeObjects\StripeAccount;
use Makeable\LaravelStripeObjects\Tests\DatabaseTestCase;
use Makeable\LaravelStripeObjects\Tests\Fakes\User;
use Stripe\Account;

class HasStripeAccountTest extends DatabaseTestCase
{
    /** @test **/
    public function it_returns_a_none_existing_stripe_account_as_default()
    {
        $this->assertInstanceOf(StripeAccount::class, $account = $this->user()->stripeAccount());
        $this->assertFalse($account->exists);
    }

    /** @test **/
    public function it_attaches_stripe_account_when_stored()
    {
        $user = $this->user();
        $account = $user->stripeAccount()->store(new Account(1));

        $this->assertTrue($user->stripeAccount()->is($account));
        $this->assertTrue($account->relations(User::class)->first()->is($user));
    }

    /** @test **/
    public function it_cascades_relations_when_storing_new_object()
    {
        $user = $this->user();
        $account1 = $user->stripeAccount()->store(new Account(1));
        $account2 = $user->stripeAccount()->store(new Account(2));

        $this->assertTrue($user->stripeAccount()->is($account2));
    }

    /** @test **/
    public function it_can_overwrite_existing_objects()
    {
        $user = $this->user();

        $account = $user->stripeAccount()->store(new Account(1));
        $account = $account->store(new Account(1));

        $this->assertTrue($user->stripeAccount()->is($account));
    }
}
