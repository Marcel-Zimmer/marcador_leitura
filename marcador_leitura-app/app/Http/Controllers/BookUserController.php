<?php

namespace App\Http\Controllers;

use App\Models\BookUser;
use Illuminate\Http\Request;

class BookUserController extends Controller
{
    public function addBookToReadingList(Request $request){
        $newBookToReading = new BookUser();
        $newBookToReading->id_book = $request->idBook;  
        $newBookToReading->id_user = auth()->user()->getAuthIdentifier();
        $newBookToReading->note = 0;
        $newBookToReading->status = "Read";   
        $newBookToReading->resume = "";
        $newBookToReading->save();
        return response()->json($newBookToReading);
    }
}
