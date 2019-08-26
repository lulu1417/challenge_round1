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
//Route::middleware('auth:api')->resource('products','ProductController',['except' => ['store']]);
Route::post('login', 'LoginController@login');
Route::resource('user','UserController',['only' => ['store']]);
Route::middleware('auth:api')->get('user', 'UserController@index');
Route::middleware('auth:api')->put('user', 'UserController@update');
Route::middleware('auth:api')->delete('user/{users}', 'UserController@destroy');
Route::middleware('auth:api')->get('logout', 'LogoutController@logout');
