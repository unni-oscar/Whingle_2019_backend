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

// Public Routes

Route::post('login', 'AuthController@login');
Route::post('register', 'AuthController@register');

//  ‘jwt.auth’ to protect your route

Route::group([
    'middleware' => 'jwt.auth',
], function ($router) {
    Route::post('test', function() {
        return "I am from protected page";
    });
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@user');
});
