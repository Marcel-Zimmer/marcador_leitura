<?php

namespace App\services;
use App\Models\BookUser;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
  
class BookUserService{
    public function markBookToReadingList(int $idBook){
        $book = new BookUser();
        $book ->id_book = $idBook;
        $book ->id_user = auth()->id();
        $book ->status= "READING";
        $book->save();
        return $book;
    }
}