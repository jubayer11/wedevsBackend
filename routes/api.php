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


Route::get('/products','dashboard\apiProductsController@index')->name('products.all');
Route::get('/product/{id}','dashboard\apiProductsController@show')->name('product.show');
Route::post('/products','dashboard\apiProductsController@store')->name('products.store');
Route::put('/products/{id}','dashboard\apiProductsController@update')->name('products.update');
Route::delete('/product/{id}','dashboard\apiProductsController@delete')->name('products.delete');



Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login')->name('dashboard.login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('signup', 'AuthController@signup');

    Route::post('reset-password', 'AuthmailController@sendPasswordResetLink');
    Route::post('reset/password', 'AuthController@callResetPassword');


});
