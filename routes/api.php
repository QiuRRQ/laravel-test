<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;
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

/*
format request harus pakai 2 header yaitu :
    'Authorization' => 'Bearer '.$token, //ini harus diambil dari token yang direturn saat login.
    'Accept' => 'application/json', //harus formatnya json karena semua return dari api akan dibuat json.
*/
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return Auth::user('api');
});

Route::post('register', 'Auth\RegisterController@register');
Route::post('login', 'Auth\LoginController@login');

Route::middleware('auth:api')->group(function(){
    Route::get('category', 'CategoryController@index');
    Route::get('category/{id}', 'CategoryController@show');
    Route::post('category', 'CategoryController@create');
    Route::put('category/{id}', 'CategoryController@update');
    Route::delete('category/{id}', 'CategoryController@destroy');

    Route::post('/product', 'ProductController@create');
    Route::put('/product/{id}', 'ProductController@product_update');
    Route::get('/product', 'ProductController@getProductBy');

    Route::delete('/variant/{id}', 'ProductController@variant_destroy');

    /*route di bawah ini adalah route untuk soal test minggu ke 4. kenapa tidak membuat project baru, pada soal nomer 6 butuh category*/

    Route::put('/AddStock/{id}', 'ProductController@add_variant_stock');
    Route::put('/stock/{id}', 'ProductController@variant_update'); //ini pakai nama route stock untuk sebagai penunjuk bahwa ini bisa digunakan untuk update stock.
    Route::get('/stock', 'ProductController@getProductStock');
    Route::get('/stock/{id}', 'ProductController@getStockBy');

    Route::post('/order', 'OrderController@create');
    Route::get('/order', 'OrderController@getOrder');
    Route::get('/order/{id}', 'OrderController@getCustomerOrder');

});
