<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

/**
 * Routes for auth
 */
Route::group(['as' => 'api:', 'prefix' => 'api/auth/'], function () {
    Route::post('register', 'Auth\AuthController@register');
    Route::post('login', 'Auth\AuthController@authenticate');
});

/**
 * Routes for user
 */
Route::group(['as' => 'api:', 'prefix' => 'api/', 'middleware' => 'jwt.auth'], function () {

    /**
     * Routes for resource user
     */
//    Route::get('user', 'UsersController@all');
//    Route::get('user/{id}', 'UsersController@get');
//    Route::post('user', 'UsersController@add');
//    Route::put('user/{id}', 'UsersController@put');
//    Route::delete('user/{id}', 'UsersController@remove');


    /**
     * Routes for resource file
     */
    Route::group(['prefix' => 'storage/'], function () {
//        Route::get('file', 'FilesController@all');
          Route::get('file/{id}', 'FilesController@get');
//        Route::post('file', 'FilesController@add');
//        Route::put('file/{id}', 'FilesController@put');
//        Route::delete('file/{id}', 'FilesController@remove');
    });
});