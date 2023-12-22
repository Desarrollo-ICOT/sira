<?php

namespace App\Exceptions;

use Exception;

class ApiException extends Exception
{
    protected $httpCode;
    protected $data;

    public function __construct($data, $httpCode = 500)
    {
        parent::__construct(isset($data['message']) ? $data['message'] : $data);
        $this->data = $data;
        $this->httpCode = $httpCode;
    }

    public function getHttpCode()
    {
        return $this->httpCode;
    }
    public function getData()
    {
        return $this->data;
    }
}
