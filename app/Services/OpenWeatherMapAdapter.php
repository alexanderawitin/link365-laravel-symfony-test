<?php

namespace App\Services;

use App\Contacts\WeatherProvider;
use App\WeatherData;
use Arr;
use Cache;
use Illuminate\Support\Facades\Http;

class OpenWeatherMapAdapter implements WeatherProvider
{
    private string $endpoint = 'https://api.openweathermap.org/data/2.5';
    private string $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function getData(string $city)
    {
        $rawWeatherData = Cache::remember('open_weather_map_data', config('services.open_weather_map.cache_ttl'), function () use ($city) {
            $response = Http::get("{$this->endpoint}/weather", [
                'lang' => 'en_US',
                'units' => 'metric',
                'appid' => $this->apiKey,
                'q' => $city,
            ])->throw();

            return $response->json();
        });

        return new WeatherData([
            'input_city' => $city,
            'resolved_city' => Arr::pull($rawWeatherData, 'name'),
            'condition' => Arr::pull($rawWeatherData, 'weather.0.main'),
            'temp' => Arr::pull($rawWeatherData, 'main.temp'),
            'temp_max' => Arr::pull($rawWeatherData, 'main.temp_max'),
            'temp_min' => Arr::pull($rawWeatherData, 'main.temp_min'),
            'pressure' => Arr::pull($rawWeatherData, 'main.pressure'),
            'wind_speed' => Arr::pull($rawWeatherData, 'wind.speed'),
            'wind_direction' => Arr::pull($rawWeatherData, 'wind.deg'),
            'humidity' => Arr::pull($rawWeatherData, 'main.humidity'),
            'visibility' => Arr::pull($rawWeatherData, 'visibility'),
            'source' => 'open_weather_map',
        ]);
    }
}
