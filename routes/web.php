<?php

use App\Http\Controllers\StaticPagesController;
use Illuminate\Support\Facades\Route;

Route::get('/', 'StaticPagesController@home');
Route::get('/help', 'StaticPagesController@help');
Route::get('/about', 'StaticPagesController@about');

// Route::get('/about', [StaticPagesController::class, 'about']);
