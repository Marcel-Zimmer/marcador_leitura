<?php

namespace App\Http\Controllers;

use App\Models\BookUser;
use App\Models\Book;
use Illuminate\Http\Request;

class BookUserController extends Controller
{
    public function addBookToReadingList(Request $request){
        $newBookToReading = new BookUser();
        $newBookToReading->id_book = $request->idBook;  
        $newBookToReading->id_user = auth()->user()->getAuthIdentifier();
        $newBookToReading->note = 0;
        $newBookToReading->status = "Reading";   
        $newBookToReading->resume = "";
        $newBookToReading->save();
        return response()->json($newBookToReading);
    }
    public function addBookToReadList(Request $request){
        $newBookToReading = new BookUser();
        $newBookToReading->id_book = $request->idBook;  
        $newBookToReading->id_user = auth()->user()->getAuthIdentifier();
        $newBookToReading->note = 0;
        $newBookToReading->status = "Read";   
        $newBookToReading->resume = "";
        $newBookToReading->save();
        return response()->json($newBookToReading);
    }

    public function getBooksToRead(){
        $userID = auth()->user()->id;
        $ListBookUser = BookUser::where('id_user', $userID)->where('status','Reading')->get();
        $books = [];
        foreach ($ListBookUser as $BookUser) {
            $newBook = Book::find($BookUser->id_book);
            $books[] = $newBook;
        }
        return response()->json($books);
    }
    public function getBooksRead(){
        $userID = auth()->user()->id;
        $ListBookUser = BookUser::where('id_user', $userID)->where('status','Read')->get();
        $books = [];
        foreach ($ListBookUser as $BookUser) {
            $newBook = Book::find($BookUser->id_book);
            $books[] = $newBook;
        }
        return response()->json($books);
    }
}
