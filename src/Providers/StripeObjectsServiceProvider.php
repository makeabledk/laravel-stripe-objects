<?php

namespace Makeable\LaravelStripeObjects\Providers;

use Illuminate\Support\ServiceProvider;
use Stripe\Stripe;

class StripeObjectsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations/');

        Stripe::setApiKey(config('services.stripe.secret'));
    }
}
