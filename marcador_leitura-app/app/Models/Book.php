<?php

namespace App\Models;

use Carbon\Language;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{   
    protected $fillable = ['id_google_books','title','authors','publisher','publishedDate','description','pageCount','categories','smallThumbnail','thumbnail','language','price','currencyCode'];


    public static function fromGoogleBooks(array $item)
    {
        return new self([
            'id_google_books' => $item['id'] ?? 'sem id',
            'title' => $item['volumeInfo']['title'] ?? 'Sem título',
            'authors' => isset($item['volumeInfo']['authors']) ? implode(', ', $item['volumeInfo']['authors']) : 'Autor desconhecido',
            'publisher' => $item['volumeInfo']['publisher'] ?? 'Sem editora',
            'publishedDate' => $item['volumeInfo']['publishedDate'] ?? 'sem data de publicação',
            'description' => $item['volumeInfo']['description'] ?? 'Sem descrição',
            'pageCount' => $item['volumeInfo']['pageCount'] ?? 'numero de páginas não informado',
            'categories' => isset($item['volumeInfo']['categories']) ? implode(', ', $item['volumeInfo']['categories']) : 'Sem categoria',
            'smallThumbnail' => $item['volumeInfo']['imageLinks']['smallThumbnail'] ?? 'Sem imagem',
            'thumbnail' => $item['volumeInfo']['imageLinks']['thumbnail'] ?? 'Sem imagem',
            'language' => $item['volumeInfo']['language'] ?? 'linguagem não informada',
            'price' => $item['saleInfo']['listPrice']['amount'] ?? 'preço não informado',
            'currencyCode' => $item['saleInfo']['listPrice']['currencyCode'] ?? 'moeda não informada',
        ]);
    }
}

