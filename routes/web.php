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

Route::get('/','DeliveryController@index');
Route::get('upload','FileUploadController@index');

Route::get('deliveries','DeliveryController@deliveries');

Route::post('uploader','FileUploadController@uploader');

