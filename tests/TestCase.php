<?php

namespace Makeable\LaravelStripeObjects\Tests;

use Illuminate\Database\Eloquent\Factory;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Makeable\LaravelStripeObjects\Providers\StripeObjectsServiceProvider;
use Makeable\LaravelStripeObjects\Tests\Fakes\User;

class TestCase extends BaseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->setUpFactories($this->app);
    }

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        putenv('APP_ENV=testing');
        putenv('APP_DEBUG=true');
        putenv('DB_CONNECTION=sqlite');
        putenv('DB_DATABASE=:memory:');

        $app = require __DIR__.'/../vendor/laravel/laravel/bootstrap/app.php';

        $app->useEnvironmentPath(__DIR__.'/..');
        $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();
        $app->register(StripeObjectsServiceProvider::class);

        return $app;
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function setUpFactories($app)
    {
        $app->make(Factory::class)->define(User::class, function ($faker) {
            return [
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => bcrypt('foo'),
            ];
        });
    }
}
