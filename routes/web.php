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
    if(!Auth::user()){
        return view('welcome');
    } else {
        return redirect('/home');
    }
});

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Video Routes...
Route::resource('videos', 'VideosController');

// Comment Routes...
Route::resource('comments', 'CommentsController');

// Other...

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/sendnotification', 'UsersController@sendNotification');
Route::get('/users', 'UsersController@index');
Route::get('/user/{id}', 'UsersController@show');
