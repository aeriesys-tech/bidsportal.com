<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Sendpulse\RestApi\ApiClient;
use Sendpulse\RestApi\Storage\FileStorage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('SendPulse', function ($app) {
            return new ApiClient(env('SENDPULSE_API_USER_ID'), env('SENDPULSE_API_SECRET'), new FileStorage());
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
