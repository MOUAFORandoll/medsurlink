<?php

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
    Route::post('/alertes', 'AlerteController@store');
    Route::get('/alertes', 'AlerteController@index');
    Route::patch('/alertes/{alerte}/subscribe', 'AlerteController@subScribeAlerte');
});