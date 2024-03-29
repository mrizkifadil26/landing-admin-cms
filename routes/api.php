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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::apiResource('posts', 'Api\v1\PostController');
Route::apiResource('locations', 'Api\v1\LocationController');
Route::apiResource('complaints', 'Api\v1\ComplaintController');
Route::apiResource('comments', 'Api\v1\CommentController');
Route::apiResource('ratings', 'Api\v1\RatingController');
Route::apiResource('users', 'Api\v1\UserController');
Route::apiResource('avatars', 'Api\v1\AvatarController');
Route::apiResource('images', 'Api\v1\ImageController');
Route::apiResource('events', 'Api\v1\EventController');
Route::apiResource('post-categories', 'Api\v1\PostCategoryController');
Route::apiResource('location-categories', 'Api\v1\LocationCategoryController');
Route::apiResource('complaint-categories', 'Api\v1\ComplaintCategoryController');
/*
Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('authenticated', 'AuthController@authenticated');
}); */

Route::prefix('auth')->group(function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::post('refresh', 'AuthController@refresh');
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('user', 'AuthController@user');
    Route::post('logout', 'AuthController@logout');
});

// Route::post('auth/login', 'AuthController@login');
// Route::post('auth/logout', 'AuthController@logout');
// Route::group(['middleware' => 'jwt.auth'], function() {
//     Route::get('auth/user', 'AuthController@me');
// });

// Route::group(['middleware' => 'jwt.refresh'], function() {
//     Route::get('auth/refresh', 'AuthController@refresh');
// });

// Route::middleware('auth:api')->group(function () {
//     Route::get('admin', function () {
//         return response()->json(['data' => 'Test Data']);
//     });
// });