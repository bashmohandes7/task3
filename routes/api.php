<?php

use App\Http\Controllers\Api\Auth\UserAuthController;
use App\Http\Controllers\Api\Post\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('user')->group(function () {
    Route::post('register', [UserAuthController::class, 'register']);
    Route::post('login', [UserAuthController::class, 'login']);
    Route::post('logout', [UserAuthController::class, 'logout'])->middleware('auth:api');
});


Route::middleware('auth:api')->group(function () {
    Route::get('/home', [PostController::class, 'index']);
    Route::post('/create', [PostController::class, 'store']);
    Route::get('/posts/{post}', [PostController::class, 'show']);
    Route::post('/posts/update/{post}', [PostController::class, 'update']);
    Route::post('/posts/delete/{post}', [PostController::class, 'destroy']);
});
