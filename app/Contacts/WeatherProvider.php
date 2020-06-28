<?php

namespace App\Contacts;

use App\WeatherData;
use Illuminate\Http\Client\RequestException;

interface WeatherProvider
{
    /**
     * @param string $city
     * @return WeatherData
     * @throws RequestException
     */
    public function getData(string $city);
}
