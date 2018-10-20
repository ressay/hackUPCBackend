<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/allEvents','EventController@getAllEvents');

Route::get('/hostEvent','EventController@hostEvent');

Route::get('/tryHost','EventController@tryHost');

Route::get('/allPlaces','PlaceController@getAllPlaces');

Route::get('/placeEvents','PlaceController@getEvents');

Route::get('/generateToken','UserController@generateToken');

Route::get('/joinEvent','UserController@joinEvent');