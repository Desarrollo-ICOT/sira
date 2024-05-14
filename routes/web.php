<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/offline', function () {
    return view('vendor/laravelpwa/offline');
});

//  Route::any('/', 'CardReaderController@index')->name('index');

Route::get('/', 'CardReaderController@index')->name('index');
Route::post('request', 'CardReaderController@requestSessions')->name('request');
Route::get('/get-health-center-code', 'CardReaderController@getHealthCenterCode');

Route::post('/simulate-csrf-token-mismatch', function () {
    abort(419, 'CSRF Token Mismatch');
})->name('simulate');

Route::get('/refresh-csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});



