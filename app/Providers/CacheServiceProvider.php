<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CacheServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CacheItemPoolInterface::class, function ($app) {
            $repository = $app->make(Repository::class);

            return new CacheItemPool($repository);
        });
    }
}
