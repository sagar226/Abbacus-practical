<?php

use Illuminate\Support\Facades\Route;

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

Route::post('registration','AuthController@userRegistration');
Route::post('update-profile','AuthController@updateProfile');
Route::get('/','AuthController@index');

Route::get('profile/{id}','AuthController@profile');
Route::get('getcategories','CategoryController@categories');
Route::get('categories','CategoryController@index');
Route::get('create-category','CategoryController@categoryForm');
Route::post('submit-category','CategoryController@create');
Route::get('category/{id}','CategoryController@getDetails');

Route::post('update-category','CategoryController@update');
Route::get('delete-category/{id}','CategoryController@delete');


Route::get('products','ProductController@index');
Route::get('getproducts','ProductController@products');
Route::get('create-products','ProductController@productForm');

Route::post('submit-product','ProductController@create');
Route::get('product/{id}','ProductController@getDetails');

Route::post('update-product','ProductController@update');
Route::get('delete-product/{id}','ProductController@delete');



Route::post('uploader','CategoryController@uploader');