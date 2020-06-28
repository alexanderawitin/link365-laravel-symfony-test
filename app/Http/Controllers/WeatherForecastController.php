<?php

namespace App\Http\Controllers;

use App\Services\AverageWeatherService;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class WeatherForecastController extends Controller
{
    private $averageWeatherService;

    public function __construct(AverageWeatherService $averageWeatherService)
    {
        $this->averageWeatherService = $averageWeatherService;
    }

    public function data(Request $request)
    {
        if ($validationResponse = $this->validateInputs($request)) {
            return $validationResponse;
        }

        try {
            return $this->averageWeatherService->getAverageWeatherData($request->input('city'));
        } catch (RequestException $e) {
            $response = response();

            switch (true) {
                case $e->getCode() >= 500:
                    $response = response('Oops! Something went wrong.', $e->getCode());
                    break;

                case $e->getCode() >= 400:
                    $response = response('Please make sure you are providing a valid `city` parameter.', $e->getCode());
                    break;
            }

            return $response;
        }
    }

    private function validateInputs(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'city' => 'required',
        ]);

        if ($validator->fails()) {
            return response('A `city` query parameter is required.', Response::HTTP_BAD_REQUEST);
        }
    }
}
