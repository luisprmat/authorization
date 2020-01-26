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

Route::get('posts/{post}', 'PostController@show')->name('post.show');

Route::post('accept-terms', 'AcceptTermsController@accept');

Route::middleware('auth')->namespace('Admin')->prefix('admin')->group(function() {
    Route::resource('posts', 'PostController');
});

Route::middleware('auth')->prefix('password')->namespace('Auth')->group(function () {
    Route::get('change', 'ChangePasswordController@showForm')->name('password.formchange');

    Route::put('change', 'ChangePasswordController@change')->name('password.change');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
