<?php

namespace Makeable\LaravelStripeObjects\Providers;

use Illuminate\Support\ServiceProvider;

class StripeObjectsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations/');
    }
}
