<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class InvalidCityException extends Exception
{
    public function __construct()
    {
        parent::__construct('Invalid City', Response::HTTP_BAD_REQUEST);
    }
}
