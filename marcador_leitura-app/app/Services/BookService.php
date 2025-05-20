<?php

namespace App\services;
use App\Models\Book;
use Illuminate\Support\Facades\Http;
  
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
        if($response->successful()){
            $items = $response->json('items') ?? [];
            return array_map(fn($item) => Book::fromGoogleBooks($item), $items);
        }
        return response()->json("deu ruim");
    }

    public function saveBook(Book $book){

    }

}