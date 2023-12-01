<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;

class ErrorHandler
{
    public static function handle(Exception $e)
    {
        Log::channel('paco')->info($e->getMessage());

        if ($e instanceof ApiException) {
            return response()->custom(false, $e->getMessage(), $e->getHttpCode(), 'danger');
        }

        return response()->custom(false, $e->getMessage(), 500, 'danger');
    }
}
