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

// пришло письмо с токеном по сбросу пароля
Route::get('/passwordreset/{token}', 'Client\ClientController@passwordResetConfirm')->name('password.reset.confirm'); 

// Admin
Route::get('/admin/login', 'Admin\Auth\LoginController@showLoginForm');
Route::post('/admin/login', 'Admin\Auth\LoginController@login')->name('login');
Route::post('/admin/logout', 'Admin\Auth\LoginController@logout')->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/{any?}', 'Admin\AdminController@index')->where('any', '.*')->name('admin');
});

// Site
Route::get('/register/{token}', 'Client\ClientController@registerConfirm')->where('any', '.*')->name('register.confirm');
Route::get('/about', 'Client\ClientController@about')->name('about.page');
Route::get('/{any?}', 'Client\ClientController@index')->where('any', '.*')->name('client');