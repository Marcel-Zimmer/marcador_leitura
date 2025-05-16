<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Services\BookService;

class BookController extends Controller
{   
    private $booksService;

    public function __construct(BookService $bookService){
        $this->booksService = $bookService;
    }

    public function serchaBookByName(Request $request)
        {   
            $date = $this->booksService->searchBooksByTitle($request->input('q'));
            return response()->json($date);
        }
    
    public function addNewBook(Request $request){

        $book = $this->booksService->saveBook($request);
        if($book){
            return response()->json("livro ja registrado");    
        }
        else{
            $newbook = new Book();
            $newbook->fill($request->all());            
            $newbook -> save();
            return response()->json($newbook);
            
        }
    }
}
