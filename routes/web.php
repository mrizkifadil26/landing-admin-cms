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
    return view('landing.landing');
});

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/logout', 'AuthController@logout');

Route::get('/posts/{post}', 'PostController@single');
Route::get('/posts', 'PostController@all');
Route::get('/admin', 'DashboardController@index');

Route::get('/{vue_capture?}', function () {
    return view('layouts.main');
})->where('vue_capture', '[\/\w\.-]*');