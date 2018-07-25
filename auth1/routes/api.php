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

// Authentication routes
Route::prefix('/auth')->group(function (){
    Route::post('register', 'Api\Auth\RegisterController@register');
    Route::post('login', 'Api\Auth\LoginController@login');
    Route::post('refresh', 'Api\Auth\LoginController@refresh');
});

// Routes protected with access_token
Route::middleware('auth:api')->group(function (){

    Route::prefix('/auth')->group(function (){
        Route::post('logout', 'Api\Auth\LoginController@logout');
    });

    Route::prefix('/users')->group(function (){
        Route::get('/', 'Api\UsersApiController@index');
        Route::post('/', 'Api\UsersApiController@create');
        Route::get('/{id}', 'Api\UsersApiController@update');
        Route::put('/{id}', 'Api\UsersApiController@update');
        Route::delete('/{id}', 'Api\UsersApiController@delete');
    });
});
