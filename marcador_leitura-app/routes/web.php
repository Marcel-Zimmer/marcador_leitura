<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;


route::get('/procurarLivro/{nameBook}', [BookController::class, 'serchaBookByName']);

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

