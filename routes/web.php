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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/customer-login', 'CustomerController@index')->name('customer.login');
Route::get('/customer-register', 'CustomerController@register')->name('customer.register');

Route::post('/check-login', 'CustomerController@checkUser')->name('customer.check');
Route::post('/save-user', 'CustomerController@saveUser')->name('customer.save');


