<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Services\BookService;
use App\Services\BookUserService;

class BookController extends Controller
{   

    public function __construct(
        protected BookService $bookService,
        protected BookUserService $bookUserService
    ) {}


    public function serchaBookByName(Request $request){  
        try{
            $data = $this->bookService->searchBooksByTitle($request->input('q'));
            return response()->json([
                'success' => true,
                'data' => $data], 201);

        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Não foi possível buscar o livro',], 500);
        }
    }
    
    public function markBookToReadingList(Request $request){
        try{
            $bookId = $this->bookService->saveBook($request);
            $this->bookUserService -> markBookToReadingList($bookId);
            return response()->json([
                'success' => true,
                'message' => $bookId,
        ], 201);
        }
        catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Não foi possível salvar o livro erro: '.$e,], 500);
        }
    }

    public function markBookToReadList(Request $request){
        try{
            $bookId = $this->bookService->saveBook($request);
            $this->bookUserService -> markBookToReadList($bookId);
            return response()->json([
                'success' => true,
                'message' => $bookId], 201);
        }
        catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Não foi possível salvar o livro erro: '.$e,], 500);
        }
    }
    public function getBooksFinished(){
        try{
            $idsBooks = $this-> bookUserService -> getBooksFinished();
            $books = $this -> bookService -> getBooks($idsBooks);
            return response()->json([
                'success' => true,
                'data' => $books ], 201);    

        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Não foi possível salvar o livro erro: '.$e,], 500);
        }
    }  

    public function getBooksNotFinished(){
        try{
            $idsBooks = $this-> bookUserService -> getBooksNotFinished();
            $books = $this -> bookService -> getBooks($idsBooks);
            return response()->json([
                'success' => true,
                'data' => $books ], 201);    

        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Não foi possível salvar o livro erro: '.$e,], 500);
        }
    }       
}
