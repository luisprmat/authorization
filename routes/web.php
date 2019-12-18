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

Route::get('posts/{post}', 'PostController@show')->name('posts.show');

Route::post('accept-terms', 'AcceptTermsController@accept');

Route::middleware('auth')->namespace('Admin')->prefix('admin/')->group(function() {
    Route::get('posts', 'PostController@index');

    Route::post('posts', 'PostController@store');

    Route::get('posts/{post}/edit', 'PostController@edit')->name('posts.edit');

    Route::put('posts/{post}', 'Postcontroller@update');

    Route::delete('posts/{post}', 'Postcontroller@destroy')->name('posts.destroy');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
