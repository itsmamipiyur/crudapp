<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/brand/brand_update', 'BrandController@brand_update');
Route::post('/brand/brand_restore', 'BrandController@brand_restore');
Route::post('/category/category_update', 'CategoryController@category_update');
Route::post('/category/category_restore', 'CategoryController@category_restore');
Route::post('/product/product_update', 'ProductController@product_update');
Route::post('/product/product_restore', 'ProductController@product_restore');

Route::group(['middleware' => ['web']], function(){
    Route::resource('brand', 'BrandController');
    Route::resource('category', 'CategoryController');
    Route::resource('product', 'ProductController');
});
