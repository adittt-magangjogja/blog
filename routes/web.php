<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FirstAdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterController;
use App\Http\Middleware\EnsureUserIsAdmin;

Route::get('/admin/dashboard', fn () => view('admin.dashboard', [
    'totalPosts' => \App\Models\Post::count(),
]))->middleware(['auth', EnsureUserIsAdmin::class]);

Route::get('/admin', fn () => view('admin.dashboard', [
    'totalPosts' => \App\Models\Post::count(),
]))->middleware(['auth', EnsureUserIsAdmin::class]);
Route::get('/', function () {
    return redirect('/posts');
});

Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('login.store');
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])
        ->middleware('throttle:5,1')
        ->name('register.store');
});
Route::get('/admin/setup', [FirstAdminController::class, 'create'])->name('first-admin.create');
Route::post('/admin/setup', [FirstAdminController::class, 'store'])
    ->middleware('throttle:3,1')
    ->name('first-admin.store');
Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::middleware('auth')->group(function () {
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
});

Route::middleware(['auth', EnsureUserIsAdmin::class])->group(function () {
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
});

Route::get('/posts/{post}', [PostController::class, 'show'])
    ->whereNumber('post')
    ->name('posts.show');
   
