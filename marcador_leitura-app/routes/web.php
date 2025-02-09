<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;


route::get('/searchBook/', [BookController::class, 'serchaBookByName'])->name('searchBook');
route::post('/addNewBook/', [BookController::class,'addNewBook'])->name('addNewBook');
route::post('/addBookToReadList/', [BookController::class,'addBookToReadList'])->name('addBookToReadList');
route::post('/addBookToReadingList/', [BookController::class,'addBookToReadingList'])->name('addBookToReadingList');

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

