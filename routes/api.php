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

Route::get('/users','dashboard\apiUserController@index')->name('user.index');
Route::post('/users','dashboard\apiUserController@store')->name('user.store');
Route::get('/user/{id}','dashboard\apiUserController@show')->name('user.show');
