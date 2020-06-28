<?php

namespace App\Services;

use App\Contacts\WeatherProvider;
use App\WeatherData;
use Arr;
use Cache;
use Illuminate\Support\Facades\Http;

class DestinationWeatherAdapter implements WeatherProvider
{
    private string $endpoint = 'https://weather.ls.hereapi.com/weather/1.0';
    private string $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function getData(string $city)
    {
        $rawWeatherData = Cache::remember('', config('services.destination_weather.cache_ttl'), function () use ($city) {
            $observationResponse = Http::get("{$this->endpoint}/report.json", [
                'product' => 'observation',
                'oneobservation' => true,
                'apiKey' => $this->apiKey,
                'name' => $city,
            ])->throw();

            $astronomyResponse = Http::get("{$this->endpoint}/report.json", [
                'product' => 'forecast_astronomy',
                'apiKey' => $this->apiKey,
                'name' => $city,
            ])->throw();

            $rawObservationData = $observationResponse->json();
            $rawAstronomyData = $astronomyResponse->json();

            return array_merge($rawObservationData, $rawAstronomyData);
        });

        return new WeatherData([
            'input_city' => $city,
            'resolved_city' => Arr::pull($rawWeatherData, 'observations.location.0.observation.0.city'),
            'condition' => Arr::pull($rawWeatherData, 'observations.location.0.observation.0.skyDescription'),
            'temp' => floatval(Arr::pull($rawWeatherData, 'observations.location.0.observation.0.temperature')),
            'temp_max' => floatval(Arr::pull($rawWeatherData, 'observations.location.0.observation.0.highTemperature')),
            'temp_min' => floatval(Arr::pull($rawWeatherData, 'observations.location.0.observation.0.lowTemperature')),
            'pressure' => floatval(Arr::pull($rawWeatherData, 'observations.location.0.observation.0.barometerPressure')),
            'wind_speed' => floatval(Arr::pull($rawWeatherData, 'observations.location.0.observation.0.windSpeed')),
            'wind_direction' => floatval(Arr::pull($rawWeatherData, 'observations.location.0.observation.0.windDirection')),
            'humidity' => floatval(Arr::pull($rawWeatherData, 'observations.location.0.observation.0.humidity')),
            'visibility' => floatval(Arr::pull($rawWeatherData, 'observations.location.0.observation.0.visibility')) * 1000,
            'source' => 'destination_weather',
        ]);
    }
}
