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

// Route::post('/entrance', 'CardReaderController@requestSessions')->name('entrance');
// Route::post('exit', 'CardReaderController@readCardForExit');

Route::prefix('sessions')->group(function () {
    Route::post('request', 'CardReaderController@requestSessions')->name('request');
    Route::post('start', 'CardReaderController@startSession')->name('start');
    Route::post('end', 'CardReaderController@endSession')->name('end');
});
