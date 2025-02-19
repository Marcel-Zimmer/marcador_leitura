<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookUserController;


route::get('/searchBook/', [BookController::class, 'serchaBookByName'])->name('searchBook');
route::post('/addNewBook/', [BookController::class,'addNewBook'])->name('addNewBook');
route::post('/addBookToReadList/', [BookUserController::class,'addBookToReadList'])->name('addBookToReadList');
route::post('/addBookToReadingList/', [BookUserController::class,'addBookToReadingList'])->name('addBookToReadingList');
route::get('/booksToRead/', [BookUserController::class,'getBooksToRead'])->name('booksToRead');
route::get('/booksRead/', [BookUserController::class,'getBooksRead'])->name('booksRead');
route::post('/removeBookReadList/', [BookUserController::class,'removeBookReadList'])->name('removeBookReadList');
route::post('/removeBookReadingList/', [BookUserController::class,'removeBookReadingList'])->name('removeBookReadingList');
route::post('/updateBookStatusToReading/', [BookUserController::class,'updateBookStatusToReading'])->name('updateBookStatusToReading');
route::post('/updateBookStatusToRead/', [BookUserController::class,'updateBookStatusToRead'])->name('updateBookStatusToRead');

route::view('getBooksToRead','booksToRead')
    ->middleware(['auth', 'verified'])
    ->name('getBooksToRead');


Route::view('/', 'welcome');

route::view('getBooksRead','booksRead')
    ->middleware(['auth', 'verified'])
    ->name('getBooksRead');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

