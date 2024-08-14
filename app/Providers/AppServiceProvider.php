<?php

namespace App\Providers;

use App\Services\TwilioService;
use Illuminate\Support\ServiceProvider;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    { 
        $this->app->singleton(TwilioService::class, function ($app) {
            return new TwilioService();
        });

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
