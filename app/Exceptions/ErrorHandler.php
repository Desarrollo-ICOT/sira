<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpFoundation\Response;

class ErrorHandler
{
    public static function handle(Exception $e)
    {
        Log::channel('paco')->error($e->getMessage());

        if ($e instanceof ApiException) {
            return response()->custom(false, $e->getData(), $e->getHttpCode(), 'danger');
        } elseif ($e instanceof TokenMismatchException) {
            return response()->custom(false, 'CSRF Token mismatch', Response::HTTP_BAD_REQUEST, 'danger');
        } else {
            // Handle other exceptions
            return response()->custom(false, $e->getMessage(), 500, 'danger');
        }
    }
}
