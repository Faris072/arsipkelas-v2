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

//role list $users = ['developer','admin','user'];
//role list $user_school = ['admin','staff','teacher','student'];

Route::post('user/register','App\Http\Controllers\Api\UserController@register');
Route::post('user/login','App\Http\Controllers\Api\UserController@login');
Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::group(['prefix' => 'user'], function(){
        Route::get('me','App\Http\Controllers\Api\UserController@me');
        Route::put('change-password','App\Http\Controllers\Api\UserController@changePassword');
        Route::post('logout','App\Http\Controllers\Api\UserController@logout');
        Route::post('upload-photo-profile','App\Http\Controllers\Api\UserController@uploadFile');
        // Route::delete('/{id}','App\Http\Controllers\Api\UserController@logout')->middleware('user:admin');
        Route::group(['middleware' => 'user:admin'], function(){
            Route::put('reset-password/{id}','App\Http\Controllers\Api\UserController@resetPassword');
        });
    });
    Route::group(['prefix' => 'school'], function(){
        Route::post('/','App\Http\Controllers\Api\SchoolController@create');
        Route::group(['middleware' => 'school:admin'], function(){
            Route::put('/{schoolId}','App\Http\Controllers\Api\SchoolController@update');
            Route::post('upload-photo/{schoolId}','App\Http\Controllers\Api\SchoolController@uploadPhoto');
            Route::post('invite','App\Http\Controllers\Api\SchoolController@invite');
        });
        Route::put('accept-invite/{schoolId}','App\Http\Controllers\Api\SchoolController@acceptInvitation');
        Route::put('reject-invite/{schoolId}','App\Http\Controllers\Api\SchoolController@rejectInvitation');

    });

    Route::group(['middleware' => 'school:admin,staff', 'prefix' => 'semester'], function(){
        Route::post('/','App\Http\Controllers\Api\SemesterController@createSemester');
        Route::put('/{semesterId}','App\Http\Controllers\Api\SemesterController@updateSemester');
        Route::delete('/{semesterId}','App\Http\Controllers\Api\SemesterController@deleteSemester');
    });
});

Route::get('unauthorized','App\Http\Controllers\Api\UserController@unauthorized')->name('unauthorized');
