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

Route::prefix('v1')->group(function () {

    Route::prefix('territories')->group(function () {
        Route::get('', 'TerritoryController@index');
        Route::post('', 'TerritoryController@store');
        Route::get('{id}', 'TerritoryController@show');
        Route::delete('{id}', 'TerritoryController@destroy');

        Route::get('order/painted', 'TerritoryController@orderPainted');
        Route::get('order/proportional/painted', 'TerritoryController@orderProportionalPainted');
        Route::get('painted/total/area', 'TerritoryController@paintedTotalArea');
    });

    Route::prefix('square')->group(function () {
        Route::get('lastPainted', "SquareController@lastPainted");
        Route::get('{x}/{y}', "SquareController@index");
        Route::patch('{x}/{y}/paint', "SquareController@paint");
    });

    Route::get("log/{limit}", "LogController@listLog");

});
