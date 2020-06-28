<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WeatherData extends Model
{
    protected $fillable = [
        'input_city',
        'resolved_city',
        'condition',
        'temp',
        'temp_max',
        'temp_min',
        'pressure',
        'wind_speed',
        'wind_direction',
        'humidity',
        'visibility',
        'source',
    ];
}
