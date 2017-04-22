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


Auth::routes();
Route::get('/', 'OrdersController@index');
Route::get('orders/statistics/{thisYear?}/{thisMonth?}','OrdersController@statistics')->name('orders.statistics');
Route::get('orders/create/{thisYear?}/{thisMonth?}/{thisDay?}','OrdersController@create')->name('orders.create');
Route::get('orders/showByMonth/{thisYear}/{thisMonth}','OrdersController@showByMonth')->name('orders.showByMonth');
Route::get('orders.cancel','OrdersController@cancel')->name('orders.cancel');
Route::get('orders.delay','OrdersController@delay')->name('orders.delay');
Route::resource('orders','OrdersController',['except'=>['create']]);
Route::resource('rooms','RoomsController',['except'=>['index']]);
Route::resource('orderStatus','OrderStatusController',['except'=>['index']]);
Route::resource('orderPlace','OrderPlaceController',['except'=>['index']]);
Route::resource('bnb','BnBController');


Route::get('user/activation/{token}', 'Auth\LoginController@activateUser')->name('user.activate');

Route::get('/home', 'HomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index');
