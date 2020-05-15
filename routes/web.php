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

Route::resource('movies', 'MoviesController');

Route::resource('reservations', 'ReservationsController');

Route::resource('screenings', 'ScreeningsController');

Auth::routes();

Route::get('admin', 'HomeController@adminHome')->name('admin')->middleware('is_admin');

Route::get('/', 'HomeController@index')->name('pageLayout');

Route::get('home', 'HomeController@index')->name('home');
