<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;

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
        //MACROS
        
        Http::macro('macro', function ($access_token) {
            return Http::withHeaders([
                'authorization' => 'Bearer ' . $access_token,
                'Ocp-Apim-Subscription-Key' => env('SUBSCRIPTION_KEY1')
            ])->baseUrl( env('API_ENDPOINT').'/');
        });


        // PendingRequest::macro('a3', function ($access_token) {
        //     return PendingRequest::withHeaders([
        //         'authorization' => 'Bearer ' . $access_token,
        //         'Ocp-Apim-Subscription-Key' => env('SUBSCRIPTION_KEY1')
        //     ])->baseUrl( env('API_ENDPOINT').'/');
        // });


        Response:: macro('success', function($data){
            return response()-> json($data);
        });

    
        Response:: macro('error', function($error, $status_code){
            return response()-> json([
                'success'=> false,
                'data'=> $error
            ], $status_code);
        });
    }
}
