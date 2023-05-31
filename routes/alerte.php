<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


## Api Specialite


Route::prefix('v3')->namespace('Api\v2\Alerte')->middleware(['client.credentials'])->group(function () {
    Route::get('/specialities', 'SpecialiteController@index');
    Route::get('/alertes/info/{user_id}', 'AlerteController@historyInfoUserAlert');
    Route::get('/alertes', 'AlerteController@index');
    Route::post('/alertes', 'AlerteController@store');
    Route::patch('/alertes/{alerte}/subscribe', 'AlerteController@subScribeAlerte');
});