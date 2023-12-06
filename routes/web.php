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

// Route::get('/', function () {
//     return view('welcome');
// });

//  Route::any('/', 'CardReaderController@index')->name('index');

Route::get('/', 'CardReaderController@index')->name('index');
Route::post('request', 'CardReaderController@requestSessions')->name('request');
Route::get('/get-health-center-code', 'CardReaderController@getHealthCenterCode');

