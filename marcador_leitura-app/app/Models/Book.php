<?php

namespace App\Models;

use Carbon\Language;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{   
    protected $fillable = ['idBook','title','authors','publisher','publishedDate','description','pageCount','categories','smallThumbnail','thumbnail','language','price','currencyCode'];
    protected $primaryKey = "idBook";
    public $incrementing = false;

    public static function fromGoogleBooks(array $item)
    {
        return new self([
            'idBook' => $item['id'] ?? null,
            'title' => $item['volumeInfo']['title'] ?? 'Sem título',
            'authors' => isset($item['volumeInfo']['authors']) ? implode(', ', $item['volumeInfo']['authors']) : 'Autor desconhecido',
            'publisher' => $item['volumeInfo']['publisher'] ?? 'Sem editora',
            'publishedDate' => $item['volumeInfo']['publishedDate'] ?? null,
            'description' => $item['volumeInfo']['description'] ?? 'Sem descrição',
            'pageCount' => $item['volumeInfo']['pageCount'] ?? null,
            'categories' => isset($item['volumeInfo']['categories']) ? implode(', ', $item['volumeInfo']['categories']) : 'Sem categoria',
            'smallThumbnail' => $item['volumeInfo']['imageLinks']['smallThumbnail'] ?? null,
            'thumbnail' => $item['volumeInfo']['imageLinks']['thumbnail'] ?? null,
            'language' => $item['volumeInfo']['language'] ?? null,
            'price' => $item['saleInfo']['listPrice']['amount'] ?? null,
            'currencyCode' => $item['saleInfo']['listPrice']['currencyCode'] ?? null,
        ]);
    }
}

