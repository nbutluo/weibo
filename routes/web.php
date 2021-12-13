<?php

use App\Http\Controllers\StaticPagesController;
use Illuminate\Support\Facades\Route;

Route::get('/', 'StaticPagesController@home')->name('home');
Route::get('/help', 'StaticPagesController@help')->name('help');
Route::get('/about', 'StaticPagesController@about')->name('about');

// Route::get('/about', [StaticPagesController::class, 'about']);
