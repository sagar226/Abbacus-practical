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