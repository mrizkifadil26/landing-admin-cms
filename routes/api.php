<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('posts', 'PostController');
Route::apiResource('users', 'Api\v1\UserController');
/*
Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('authenticated', 'AuthController@authenticated');
}); */

Route::post('auth/login', 'AuthController@login');
Route::post('auth/logout', 'AuthController@logout');
Route::group(['middleware' => 'jwt.auth'], function() {
    Route::get('auth/user', 'AuthController@me');
});

Route::group(['middleware' => 'jwt.refresh'], function() {
    Route::get('auth/refresh', 'AuthController@refresh');
});

Route::middleware('auth:api')->group(function () {
    Route::get('admin', function () {
        return response()->json(['data' => 'Test Data']);
    });
});