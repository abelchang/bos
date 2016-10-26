<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'OrdersController@index');

Route::get('orders/showByMonth/{thisYear}/{thisMonth}','OrdersController@showByMonth')->name('orders.showByMonth');
Route::resource('orders','OrdersController');
Route::resource('rooms','RoomsController',['except'=>['index']]);
Route::resource('orderStatus','OrderStatusController',['except'=>['index']]);
Route::resource('orderPlace','OrderPlaceController',['except'=>['index']]);



