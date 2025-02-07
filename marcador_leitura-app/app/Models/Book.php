<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Book extends Model
{
    protected $fillable = ['title','authors','description','imagemLink'];

    private function getBooksFromApi($searchBook){
        $nameSearch = str_replace(' ','+', $searchBook);
        $urlTitleBook = "https://www.googleapis.com/books/v1/volumes?q=intitle:";
        $filterPortuguese = "&langRestrict=pt";
        $keyApi = "&key=AIzaSyCWyMf_m1IDlc2VBIjxQNGAaMn8JtJxODM";
        $searchBook = $urlTitleBook."".$nameSearch."".$filterPortuguese."".$keyApi;
        $response = Http::get($searchBook);

        if($response->successful()){
            return $response->json();
        }
        return [];

    }   

    public function searchBooks($searchBook){
        $booksData = $this->getBooksFromApi($searchBook);
        if(isset($booksData['items'])){
            $books = [];
            foreach($booksData['items'] as $bookData){
                $books[] = new self([
                    'title' => $bookData['volumeInfo']['title'] ?? 'Sem título',
                    'authors' => implode(', ', $bookData['volumeInfo']['authors'] ?? ['Autor desconhecido']),
                    'description' => $bookData['volumeInfo']['description'] ?? 'Sem descrição',
                    'imagemLink' => $bookData['volumeInfo']['imageLinks']['thumbnail'] ?? ''
                ]);
            }
            return $books;
        }
    }
}

