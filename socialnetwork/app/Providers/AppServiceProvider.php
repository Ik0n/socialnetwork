<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->bind(
            'App\Contracts\Service',
            'App\Services\ProductService'
        );

        $this->app->bind(
            'App\Contracts\UserService',
            'App\Services\UserService'
        );
    }
}
