<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class ErrorHandler
{
    public static function handle(Exception $e)
    {
        Log::channel('error')->error($e->getMessage());
        if ($e instanceof ApiException) {
            return response()->custom(false, $e->getData(), $e->getHttpCode(), 'danger');
        } else{
            return response()->custom(false, $e->getMessage(), 500, 'danger');
        }
    }
}
