<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware('auth')->group(function() {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/add-book', [App\Http\Controllers\BookController::class, 'create'])->name('add-book');
    Route::post('/save-book', [App\Http\Controllers\BookController::class, 'store'])->name('save-book');

    Route::prefix('view')->group(function () {
        Route::get('book/{id}', [App\Http\Controllers\BookController::class, 'show'])->name('view.book');
        Route::get('author/{id}', [App\Http\Controllers\AuthorController::class, 'show'])->name('view.author');
    });

    Route::prefix('delete')->group(function () {
        Route::get('/single-book/{id}', [App\Http\Controllers\BookController::class, 'destroy'])->name('delete/single-book');
        Route::get('/single-author/{id}', [App\Http\Controllers\AuthorController::class, 'destroy'])->name('delete/single-author');
    });
});
