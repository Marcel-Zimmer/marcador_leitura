<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    public function serchaBookByName(Request $request)
        {   
            $searchTerm = $request->input('q'); // pega as informações digitadas no forumlario
            $searchQuery = 'intitle:' . urlencode($searchTerm); //adiciona intitle antes das informações e tranforma a pesquisa para o tipo de pesquisa url 
            $url = 'https://www.googleapis.com/books/v1/volumes?q=' . $searchQuery; //constroi a url inteira 
            $bookModel = new Book();
            $books = $bookModel->searchBooks($url);
            return response()->json($books);
            
        }
    
    public function addNewBook(Request $request){
        
        $book = Book::find($request->input('idBook'));
        if($book){
            
            return response()->json("livro ja registrado");    
        }
        else{
            $newbook = new Book();
            $newbook->fill($request->all());
            $newbook -> save();
            return response()->json("livro registrado");
        }

        
    }
}
