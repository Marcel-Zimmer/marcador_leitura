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
        try{
            $this->booksService->saveBook($request);
            return response()->json([
            'success' => true,
            'message' => 'Livro salvo com sucesso',
            'data' => $book 
        ], 201);
        }
        catch (\Exception $e){
            return response()->json([
            'success' => false,
            'message' => 'Não foi possível salvar o livro',
        ], 500);
        }
    }
}
