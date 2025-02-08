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
        //$bookModel->testDatabase($url);
        $books = $bookModel->searchBooks($url);
        $books[0] -> save();
        return response()->json($books);
        

        
                
        /*if (count($books) > 0) {
            // Retorna a view 'books' com os dados dos livros
            return response()->json($books);
        } 
        return [];*/
    }
}
