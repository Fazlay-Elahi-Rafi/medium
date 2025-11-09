<?php

use App\Http\Controllers\ClapController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// For Public profile [- I don't need to SignIn/SignOut to visit the user profile ]
Route::get('/@{user:username}', [PublicProfileController::class, 'show'])->name('profile.show');

Route::get('/', [PostController::class, 'index'])->name('dashboard');
Route::get('/@{username}/{post:slug}', [PostController::class, 'show'])->name('post.show');
/*
 @{username}:
    - This is a route parameter called username.
    - The @ is just part of the URL string (like in social media handles).
    - For example, /@john → username = john.

 {post:slug}:
    - You can tell Laravel to use another field like slug instead of id:
*/

Route::get('/category/{category}', [PostController::class, 'category'])->name('post.byCategory');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/my-post', [PostController::class, 'myPost'])->name('myPost');
    Route::get('/post/create', [PostController::class, 'create'])->name('post.create');
    Route::post('/post', [PostController::class, 'store'])->name('post.store');
    Route::get('/post/{post:slug}', [PostController::class, 'edit'])->name('post.edit');
    Route::put('/post/{post}', [PostController::class, 'update'])->name('post.update');
    Route::delete('/post/{post}', [PostController::class, 'destroy'])->name('post.destroy');


    Route::post('/follow/{user}', [FollowerController::class, 'followUnfollow'])->name('follow');
    Route::post('/clap/{post}', [ClapController::class, 'clap'])->name('clap');
    // Route::get('/category/{category}', [PostController::class, 'category'])->name('post.byCategory');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
