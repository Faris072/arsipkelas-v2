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

Route::post('user/register','App\Http\Controllers\Api\UserController@register');
Route::post('user/login','App\Http\Controllers\Api\UserController@login');
Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::group(['prefix' => 'user'], function(){
        Route::get('me','App\Http\Controllers\Api\UserController@me');
        Route::put('change-password','App\Http\Controllers\Api\UserController@changePassword');
        Route::post('logout','App\Http\Controllers\Api\UserController@logout');
        Route::put('reset-password/{id}','App\Http\Controllers\Api\UserController@resetPassword')->middleware('admin');
        Route::post('upload-photo-profile','App\Http\Controllers\Api\UserController@uploadFile');
    });
    Route::group(['prefix' => 'school'], function(){
        Route::post('create','App\Http\Controllers\Api\SchoolController@create');
        Route::group(['middleware', 'admin-school'], function(){
            Route::post('update/{id}','App\Http\Controllers\Api\SchoolController@update');
        });
    });
});
