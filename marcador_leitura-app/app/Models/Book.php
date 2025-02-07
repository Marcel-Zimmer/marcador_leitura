<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Book extends Model
{
    protected $fillable = ['title','authors','description','imagemLink'];
    
    private function getBooksFromApi($url){ // função responsável por consultar a api do google e retornar um json 
        $filterPortuguese = "&langRestrict=pt";
        $keyApi = "&key=AIzaSyCWyMf_m1IDlc2VBIjxQNGAaMn8JtJxODM";
        $searchBook = $url."".$filterPortuguese."".$keyApi;
        $response = Http::get($searchBook);

        if($response->successful()){
            return $response->json();
        }
        return [];

    }   

    public function searchBooks($url){ // função que recebe um json de getBooksFromAPi e lida com a criação de um array do tipo Book 
        $booksData = $this->getBooksFromApi($url);
        if(isset($booksData['items'])){
            $books = [];
            foreach($booksData['items'] as $bookData){
                $imagemLink = isset($bookData['volumeInfo']['imageLinks']['thumbnail']) 
                ? $bookData['volumeInfo']['imageLinks']['thumbnail'] 
                : 'Sem imagem';
                $books[] = new self([
                    'title' => $bookData['volumeInfo']['title'] ?? 'Sem título',
                    'authors' => implode(', ', $bookData['volumeInfo']['authors'] ?? ['Autor desconhecido']),
                    'description' => $bookData['volumeInfo']['description'] ?? 'Sem descrição',
                    'imagemLink' => $imagemLink
                ]);
            }
            
            return $books;
        }
    }
}

