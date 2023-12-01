<?php

namespace App\Exceptions;

use Exception;

class ApiException extends Exception
{
    protected $httpCode;

    public function __construct($message, $httpCode = 500)
    {
        parent::__construct($message);
        $this->httpCode = $httpCode;
    }

    public function getHttpCode()
    {
        return $this->httpCode;
    }
}
