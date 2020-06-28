<?php

namespace App\Providers;

use App\Services\AverageWeatherService;
use App\Services\DestinationWeatherAdapter;
use App\Services\OpenWeatherMapAdapter;
use Illuminate\Support\ServiceProvider;

class AverageWeatherServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(AverageWeatherService::class, function () {
            return new AverageWeatherService(
                new DestinationWeatherAdapter(config('services.destination_weather.key')),
                new OpenWeatherMapAdapter(config('services.open_weather_map.key'))
                // Append additional weather sources here (must implement the App\Contacts\WeatherProvider contract)
            );
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
