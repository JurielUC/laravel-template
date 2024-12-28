<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

/** PasswordsController (Start) */
Route::post('/password/forgot', 'App\Http\Controllers\API\PasswordsController@forgot')->name('password.forgot');
Route::post('/password/change', 'App\Http\Controllers\API\PasswordsController@change')->name('password.change');
/** PasswordsController (End) */

/** Notifications (Start) */
Route::get('/notification/count', 'App\Http\Controllers\API\NotificationsController@record_count')->name('notification.count');
Route::get('/notification', 'App\Http\Controllers\API\NotificationsController@index')->name('notification.index');
Route::post('/notification/{id}/read', 'App\Http\Controllers\API\NotificationsController@read')->name('notification.read');
/** Notifications (End) */

/* AUTH */
Route::post('/login', 'App\Http\Controllers\API\AuthController@login')->name('login');
Route::post('/register', 'App\Http\Controllers\API\AuthController@register')->name('register');
Route::post('/resend/verification/{id}', 'App\Http\Controllers\API\AuthController@email_verification_resend');

Route::post('file/upload', 'App\Http\Controllers\API\UsersController@universal_uploader');
Route::post('all/file/upload', 'App\Http\Controllers\API\UsersController@universal_file_uploader');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', 'App\Http\Controllers\API\AuthController@logout');
    
    Route::resource('user', 'App\Http\Controllers\API\UsersController');
});