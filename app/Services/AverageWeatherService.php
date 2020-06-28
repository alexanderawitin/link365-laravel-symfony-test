<?php

namespace App\Services;

use App\Contacts\WeatherProvider;
use App\WeatherData;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Collection;

class AverageWeatherService
{
    protected Collection $weatherSources;

    public function __construct(...$weatherSources)
    {
        $this->weatherSources = collect($weatherSources)->reject(function ($value) {
            return empty($value) || !($value instanceof WeatherProvider);
        });
    }

    /**
     * @param string $city
     * @return WeatherData
     * @throws RequestException
     */
    public function getAverageWeatherData(string $city)
    {
        try {
            $weatherData = $this->weatherSources->map(function (WeatherProvider $provider) use ($city) {
                return $provider->getData($city);
            });
        } catch (RequestException $e) {
            throw $e;
        }

        $totaledWeatherData = $weatherData->reduce(function (?WeatherData $carry, WeatherData $data) {
            return new WeatherData([
                'temp' => ($carry ? $carry->temp : 0) + $data->temp,
                'temp_max' => ($carry ? $carry->temp_max : 0) + $data->temp_max,
                'temp_min' => ($carry ? $carry->temp_min : 0) + $data->temp_min,
                'pressure' => ($carry ? $carry->pressure : 0) + $data->pressure,
                'wind_speed' => ($carry ? $carry->wind_speed : 0) + $data->wind_speed,
                'wind_direction' => ($carry ? $carry->wind_direction : 0) + $data->wind_direction,
                'humidity' => ($carry ? $carry->humidity : 0) + $data->humidity,
                'visibility' => ($carry ? $carry->visibility : 0) + $data->visibility,
            ]);
        });

        // Used for getting values that cannot be averaged or at least, difficult to.
        $preferredSource = $weatherData->first(function (WeatherData $data) {
            return $data->source === 'open_weather_map';
        });

        $averagedWeatherData = new WeatherData([
            'input_city' => $city,
            'resolved_city' => $preferredSource->resolved_city,
            'condition' => $preferredSource->condition,
            'temp' => $totaledWeatherData->temp / $weatherData->count(),
            'temp_max' => $totaledWeatherData->temp_max / $weatherData->count(),
            'temp_min' => $totaledWeatherData->temp_min / $weatherData->count(),
            'pressure' => $totaledWeatherData->pressure / $weatherData->count(),
            'wind_speed' => $totaledWeatherData->wind_speed / $weatherData->count(),
            'wind_direction' => $totaledWeatherData->wind_direction / $weatherData->count(),
            'humidity' => $totaledWeatherData->humidity / $weatherData->count(),
            'visibility' => $totaledWeatherData->visibility / $weatherData->count(),
            'source' => 'averaged',
        ]);

        return $averagedWeatherData;
    }
}
