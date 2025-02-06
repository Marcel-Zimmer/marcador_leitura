<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookController extends Controller
{
    public function serchaBookByName($name){
        $url = "https://openlibrary.org/search.json?q=title:crime+e+castigo&language=por";
        $response = file_get_contents($url);
        $dados = json_decode($response, true);
        return $dados;
    }
}
