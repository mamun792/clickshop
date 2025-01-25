<?php

namespace App\Providers;

use App\Services\Admin\CourierConfigService\CourierConfigService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;


class CourierConfigServiceProvider extends ServiceProvider
{
   

    public function register(): void
    {
        $this->app->singleton(CourierConfigService::class, function ($app) {

                return new CourierConfigService();

        });


    }


    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->make(CourierConfigService::class)->loadSettings();
    }
}
