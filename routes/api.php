<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\Activitylog\Models\Activity;

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
Route::get('/users', 'dashboard\apiUserController@index')->name('user.index');
Route::post('/users', 'dashboard\apiUserController@store')->name('user.store');
Route::get('/user/{id}', 'dashboard\apiUserController@show')->name('user.show');

//products
Route::get('/products', 'dashboard\apiProductsController@index')->name('products.all');
Route::get('/product/{id}', 'dashboard\apiProductsController@show')->name('product.show');
Route::post('/products', 'dashboard\apiProductsController@store')->name('products.store');
Route::put('/product/{id}', 'dashboard\apiProductsController@update')->name('products.update');
Route::delete('/product/{id}', 'dashboard\apiProductsController@destroy')->name('products.delete');

//homeProducts
Route::get('/homeProducts', 'dashboard\apiProductsController@getHomeProducts')->name('products.home');

//cart
Route::post('/cart', 'project\apiCartController@addProductToCart')->name('cart.add');
Route::get('/cart/count/{id}', 'project\apiCartController@getCartCount')->name('cart.count');
Route::get('/cart/{userId}', 'project\apiCartController@getCartProduct')->name('cart.get');
Route::delete('/cart/{cartId}', 'project\apiCartController@deleteCartProduct')->name('cart.delete');
Route::post('/cart/update', 'project\apiCartController@updateCartProduct')->name('cart.delete');

//productsProduct
Route::get('/productProducts/{key}/{sort}', 'dashboard\apiProductsController@getproductProducts')->name('products.product');

//order
Route::post('/order', 'project\apiOrderController@store')->name('order.store');
Route::get('/my/order/{id}', 'project\apiOrderController@getuserOrder')->name('order.index');
Route::get('/my/order/product/{id}', 'project\apiOrderController@showProduct')->name('order.showProduct');
Route::delete('/my/order/product/{id}', 'project\apiOrderController@orderDeleteProduct')->name('order.showProduct');
Route::post('/order/update', 'project\apiOrderController@updateOrder')->name('order.update');
Route::get('/order/history/{orderId}', 'project\apiOrderController@UserOrderHistory')->name('order.history');

//dashboard order
Route::get('order/all', 'project\apiOrderController@getAllOrder')->name('order.all');
Route::put('order/edit/{id}', 'project\apiOrderController@editOrder')->name('order.edit');


//notification
Route::get('/user/{id}/notification', 'dashboard\apiNotificationController@index');
Route::get('/user/{id}/notification/markRead', 'dashboard\apiNotificationController@markAsRead');

//dashboard
Route::get('/wedevs','dashboard\apiNotificationController@getDashboardData');


//activity log
Route::get('/activity', function () {
    return Activity::all();
});


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
