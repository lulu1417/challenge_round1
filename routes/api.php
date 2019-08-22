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
Route::resource('user','ProductController',['only' => ['store']]);
//Route::middleware('auth:api')->resource('products','ProductController');
Route::middleware('auth:api')->get('user', 'ProductController@index');
Route::middleware('auth:api')->put('user', 'ProductController@update');
Route::middleware('auth:api')->delete('user/{users}', 'ProductController@destroy');
