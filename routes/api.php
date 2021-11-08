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
//dashboard routes

//user
Route::get('/users','dashboard\apiUserController@index')->name('user.index');
Route::post('/users','dashboard\apiUserController@store')->name('user.store');
Route::get('/user/{id}','dashboard\apiUserController@show')->name('user.show');

//products
Route::get('/products','dashboard\apiProductsController@index')->name('products.all');
Route::get('/product/{id}','dashboard\apiProductsController@show')->name('product.show');
Route::post('/products','dashboard\apiProductsController@store')->name('products.store');
Route::put('/product/{id}','dashboard\apiProductsController@update')->name('products.update');
Route::delete('/product/{id}','dashboard\apiProductsController@destroy')->name('products.delete');

//homeProducts
Route::get('/homeProducts','dashboard\apiProductsController@getHomeProducts')->name('products.home');

//cart
Route::post('/cart','project\apiCartController@addProductToCart')->name('cart.add');
Route::get('/cart/count/{id}','project\apiCartController@getCartCount')->name('cart.count');



//productsProduct
Route::get('/productProducts/{key}/{sort}','dashboard\apiProductsController@getproductProducts')->name('products.product');


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login')->name('dashboard.login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('signup', 'AuthController@signup');
});
