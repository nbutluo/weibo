<?php

use App\Http\Controllers\StaticPagesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', 'StaticPagesController@home')->name('home');
Route::get('/help', 'StaticPagesController@help')->name('help');
Route::get('/about', 'StaticPagesController@about')->name('about');

// Route::get('/about', [StaticPagesController::class, 'about']);
Route::get('signup', 'UserController@create')->name('signup');
Route::resource('users', 'UserController');

Route::get('login', 'SessionsController@create')->name('login');
Route::post('login', 'SessionsController@store')->name('login');
Route::delete('logout', 'SessionsController@destroy')->name('logout');

Route::get('signup/confirm/{token}', [UserController::class, 'confirmEmail'])->name('confirm_email');

Route::get('password/reset',  'PasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email',  'PasswordController@sendResetLinkEmail')->name('password.email');

Route::get('password/reset/{token}',  'PasswordController@showResetForm')->name('password.reset');
Route::post('password/reset',  'PasswordController@reset')->name('password.update');

Route::resource('statuses', 'StatusesController')->only(['store', 'destroy']);

Route::get('/users/{user}/followings', 'UserController@followings')->name('users.followings');
Route::get('/users/{user}/followers', 'UserController@followers')->name('users.followers');

Route::post('/users/followers/{user}', 'FollowersController@store')->name('followers.store');
Route::delete('/users/followers/{user}', 'FollowersController@destroy')->name('followers.destroy');
