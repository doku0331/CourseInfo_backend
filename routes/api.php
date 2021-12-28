<?php

use App\Http\Controllers\Api\Course\CourseLikeController;
use App\Http\Controllers\Api\User\UserController;
use App\Http\Controllers\Auth\ApiController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommentMessageController;
use App\Http\Controllers\CourseController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('courses', CourseController::class);

Route::apiResource('comments', CommentController::class);

Route::apiResource('messages', CommentMessageController::class);

Route::get('/course/{course}/comments/', [CourseController::class, 'CourseComment']);
Route::get('/comment/{comment}/messages/', [CommentController::class, 'CommentMessage']);

Route::get('/user/likes', [UserController::class, 'userLike']);
Route::get('/user/mypublish', [UserController::class, 'myPublish']);

Route::apiResource('courses.likes', CourseLikeController::class)->only(['store']);

Route::post('/register', [ApiController::class, 'register']);
Route::post('/login', [ApiController::class, 'login']);
Route::post('/refresh', [ApiController::class, 'refresh']);
Route::post('/logout', [ApiController::class, 'logout']);
