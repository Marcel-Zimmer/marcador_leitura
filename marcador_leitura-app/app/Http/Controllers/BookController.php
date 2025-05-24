<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Services\BookService;
use App\Services\BookUserService;

class BookController extends Controller
{   
    private $bookService;
    private $bookUserService;

    public function __construct(BookService $bookService, BookUserService $bookUserService){
        $this->bookService = $bookService;
        $this->bookUserService = $bookUserService;
    }


    public function serchaBookByName(Request $request){  
        try{
            $data = $this->bookService->searchBooksByTitle($request->input('q'));
            return response()->json([
            'success' => true,
            'data' => $data], 201);

        }catch (\Exception $e){
            return response()->json([
            'success' => false,
            'message' => 'Não foi possível buscar o livro',
        ], 500);
        }
    }
    
    public function markBookToReadingList(Request $request){
        try{
            $book = $this->bookService->saveBook($request);
            $teste = $this->bookUserService -> markBookToReadingList($book -> id);
            return response()->json([
            'success' => true,
            'message' => $teste,
        ], 201);
        }
        catch (\Exception $e){
            return response()->json([
            'success' => false,
            'message' => 'Não foi possível salvar o livro erro: '.$e,

        ], 500);
        }
    }
}
