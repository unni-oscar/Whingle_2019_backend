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
Route::post('register', 'AuthController@store');
Route::post('verify', 'AuthController@verify');
Route::post('reset-password', 'AuthController@resetPassword');
Route::get('register', 'AuthController@register');


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
    Route::post('change-password', 'AuthController@changePassword');

    Route::get('profile', 'ProfileController@index');
    Route::post('profile', 'ProfileController@update');

    Route::get('states/{country}', 'CountryController@states');
    Route::get('cities/{state}', 'StateController@cities');
    Route::get('castes/{religion}', 'ReligionController@castes');

    Route::get('search', 'SearchController@index');
    Route::post('search', 'SearchController@filter');

    Route::get('show/{secret_id}', 'ProfileController@show');
    
    Route::post('sendMessage', 'MessageController@send');
    Route::post('sendInterest', 'InterestController@send');
    Route::post('hasMsgPermission', 'AuthController@hasMsgPermission');
    Route::post('addToFavourite', 'FavouriteController@add');
    Route::post('sendRequest', 'ProfileRequestController@send');
    Route::post('getInterestsReceived', 'InterestController@interestReceived');
    Route::post('getInterestsSent', 'InterestController@interestSent');
    Route::post('replyInterest', 'InterestController@replyInterest');
    
    Route::post('getFavourites', 'FavouriteController@getFavourites');


});
