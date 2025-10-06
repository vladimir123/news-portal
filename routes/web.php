<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AuthController;

//public
Route::get('/', [ArticleController::class, 'index'])->name('home');
Route::get('/articles/{id}', [ArticleController::class, 'show'])->name('articles.show');

//comments
Route::post('/articles/{article}/comments', [CommentController::class, 'store'])->name('comments.store');

//auth
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//admin
Route::middleware("auth")->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        if (!auth()->user()->is_admin) {
            return redirect('/login')->with('error', 'Access denied');
        }
        return redirect()->route('admin.articles.index');
    });

    //articles
    Route::get('/articles', [ArticleController::class, 'adminIndex'])->name('articles.index');
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/articles/{article}', [ArticleController::class, 'update'])->name('articles.update');
    Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');

    //comments
    Route::get('/comments', [CommentController::class, 'adminIndex'])->name('comments.index');
    Route::patch('/comments/{comment}/approve', [CommentController::class, 'approve'])->name('comments.approve');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});
