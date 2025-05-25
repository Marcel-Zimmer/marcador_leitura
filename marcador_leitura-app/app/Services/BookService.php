<?php

namespace App\Services;
use App\Models\Book;
use App\Models\UserBook;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
  
class BookService{
    private $urlTitle = 'https://www.googleapis.com/books/v1/volumes?q=intitle:'; //url para pesquisa na api do google 
    private $filterPortuguese = "&langRestrict=pt"; //filtro para linguagem 
    private $keyApi;
    private $maxResult = "&maxResults=40"; //resultado maximo de livros
    public function __construct() {
        $this->keyApi = env('KEY_GOOGLE_BOOKS'); //importação da key do .env
    }

    public function searchBooksByTitle(String $title){ //função faz a consulta na api e retorna um array de livros
        
        $searchQuery = $this->urlTitle . $title .$this->filterPortuguese.$this->keyApi.$this->maxResult;
        $response = Http::get($searchQuery);
        if(!$response->successful()){
            throw new Exception("erro ao carregar os livros");
        }
        $items = $response->json('items') ?? [];
        return array_map(fn($item) => Book::fromGoogleBooks($item), $items);
    }

    public function saveBook(Request $request){
        $existingBook = Book::where('id_google_books', $request->id_google_books)->first();
        if ($existingBook) {
            return $existingBook -> id; 
        }
        $newBook = new Book($request -> all());
        $newBook->save(); 
        return $newBook -> id;   
    }

    public function getBooks(array $ids){
        return Book::whereIn('id', $ids)->get();
    }

}