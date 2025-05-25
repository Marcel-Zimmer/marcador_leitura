<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookUserController;


route::get('/searchBook/', [BookController::class, 'serchaBookByName'])->name('searchBook');
route::get('/getBooksNotFinished/', [BookController::class, 'getBooksNotFinished'])->name('getBooksNotFinished');
route::get('/getBooksFinished/', [BookController::class, 'getBooksFinished'])->name('getBooksFinished');

route::post('/markBookToReadingList/', [BookController::class,'markBookToReadingList'])->name('markBookToReadingList');
route::post('/markBookToReadList/', [BookController::class,'markBookToReadList'])->name('markBookToReadList');

route::post('/addBookToReadList/', [BookUserController::class,'addBookToReadList'])->name('addBookToReadList');
route::post('/addBookToReadingList/', [BookUserController::class,'addBookToReadingList'])->name('addBookToReadingList');
route::get('/booksToRead/', [BookUserController::class,'getBooksToRead'])->name('booksToRead');
route::get('/booksRead/', [BookUserController::class,'getBooksRead'])->name('booksRead');
route::post('/removeBookReadList/', [BookUserController::class,'removeBookReadList'])->name('removeBookReadList');
route::post('/removeBookReadingList/', [BookUserController::class,'removeBookReadingList'])->name('removeBookReadingList');
route::post('/updateBookStatusToReading/', [BookUserController::class,'updateBookStatusToReading'])->name('updateBookStatusToReading');
route::post('/updateBookStatusToRead/', [BookUserController::class,'updateBookStatusToRead'])->name('updateBookStatusToRead');

Route::get('/get-csrf-token', function() {
    return response()->json(['token' => csrf_token()]);
});
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

