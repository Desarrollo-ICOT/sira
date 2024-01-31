<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::setUTF8(true);
        Carbon::setLocale(config('app.locale'));
        setlocale(LC_ALL, 'es_MX', 'es', 'ES', 'es_MX.utf8');

        //MACROS
        Http::macro('macro', function ($access_token) {
            return Http::withHeaders([
                'authorization' => 'Bearer ' . $access_token,
                'Ocp-Apim-Subscription-Key' => env('SUBSCRIPTION_KEY1')
            ])->baseUrl(env('API_ENDPOINT') . '/');
        });

        Response::macro('custom', function ($success, $data, $status_code, $ledColor = null) {
            $response ['success'] = $success;
            if (is_array($data)) {
                foreach ($data as $key => $value) {
                    $response[$key] = $value;
                }
            } else {
                $response = [
                    'success' => $success,
                    'message' => $data,
                ];
            }
            if ($ledColor) {
                $response['led_color'] = $ledColor;
            }
            return response()->json($response, $status_code);
        });
    }
}
