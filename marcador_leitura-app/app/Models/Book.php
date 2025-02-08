<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Book extends Model
{
    protected $fillable = ['idBook','title','authors','publisher','publishedDate','description','pageCount','categories','smallThumbnail','thumbnail','language','price','currencyCode'];
    
    private function getBooksFromApi($url){ // função responsável por consultar a api do google e retornar um json 
        $filterPortuguese = "&langRestrict=pt";
        $keyApi = "&key=AIzaSyCWyMf_m1IDlc2VBIjxQNGAaMn8JtJxODM";
        $searchBook = $url."".$keyApi;
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
                if(isset($bookData['volumeInfo']['imageLinks']['smallThumbnail']) || isset($bookData['volumeInfo']['imageLinks']['thumbnail'])){
                    $books[] = new self([
                        'idBook' => $bookData['id'] ?? 'Sem id',
                        'title' => $bookData['volumeInfo']['title'] ?? 'Sem título',
                        'authors' => implode(', ', $bookData['volumeInfo']['authors'] ?? ['Autor desconhecido']),
                        'publisher'=> $bookData['volumeInfo']['publisher'] ??'Sem editora',
                        'publishedDate' => $bookData['volumeInfo']['publishedDate'] ??'Sem data de publicação',
                        'description' => $bookData['volumeInfo']['description'] ?? 'Sem descrição',
                        'pageCount' => $bookData['volumeInfo']['pageCount'] ??'Número de páginas não informado',
                        'categories' => implode(', ', $bookData['volumeInfo']['categories'] ?? ['Sem categoria']),
                        'smallThumbnail' => $bookData['volumeInfo']['imageLinks']['smallThumbnail'] ?? ['sem imagem'],
                        'thumbnail' => $bookData['volumeInfo']['imageLinks']['thumbnail'] ?? ['Sem imagem'],
                        'language' => $bookData['volumeInfo']['language'] ?? ['Sem Linguagem'],
                        'price' => $bookData['saleInfo']['listPrice']['amount'] ??'Valor não informado',
                        'currencyCode' => $bookData['saleInfo']['listPrice']['currencyCode'] ??'Código não informado',

                    ]);
                }
            }
            
            return $books;
        }
    }

    public function testDatabase($url){
        $books[] = $this->searchBooks($url);
        
        //Book::insert($books);
    }
}

