<?php

namespace App\Providers;

use App\Services\WeatherService;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class WeatherServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(WeatherService::class, function ($app) {
            return new WeatherService(
                new Client([
                    'base_uri' => 'https://api.openweathermap.org/data/2.5/',
                    'timeout'  => 5.0,
                ])
            );
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
