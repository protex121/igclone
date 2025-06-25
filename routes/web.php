<?php

use App\Http\Controllers\FollowController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth', 'verified']], function () {
    //user
    Route::resource('/users', UserController::class)->only(['index', 'show', 'edit', 'update']);

    // follow or unfollow
    Route::get('/users/{user}/followers', [FollowController::class, 'followers'])->name('users.followers');
    Route::get('/users/{user}/followings', [FollowController::class, 'followings'])->name('users.followings');
    Route::post('/follows/{user}', [FollowController::class, 'toggle'])->name('follows.toggle');

    // likes
    Route::post('/likes/{post}', [LikeController::class, 'toggle'])->name('likes.toggle');

    // comments
    Route::resource('/comments', CommentController::class)->only(['store', 'destroy']);

    // posts
    Route::get('/post/create', [PostController::class, 'create'])->name('post.create');
    Route::post('/post/store', [PostController::class, 'store'])->name('posts.store');
    Route::resource('/posts', PostController::class)->except(['index']);
});
