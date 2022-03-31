<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PostsController;
use App\Http\Controllers\API\PostCommentsController;

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

Route::get('posts/{id}', [PostsController::class, 'show']);
Route::get('posts/{id}/comments', [PostsController::class, 'showFromComments']);
Route::get('posts', [PostsController::class, 'index']);
Route::get('posts-comments', [PostsController::class, 'indexComments']);
Route::post('posts', [PostsController::class, 'create']);
Route::put('posts/{id}', [PostsController::class, 'update']);
Route::delete('posts/{id}', [PostsController::class, 'destroy']);
Route::post('upvote/{post_id}', [PostsController::class, 'upvote']);
//upvote

Route::get('comments/{id}', [PostCommentsController::class, 'show']);
Route::get('comments', [PostCommentsController::class, 'index']);
Route::post('comments', [PostCommentsController::class, 'create']);
Route::put('comments/{id}', [PostCommentsController::class, 'update']);
Route::delete('comments/{id}', [PostCommentsController::class, 'destroy']);

