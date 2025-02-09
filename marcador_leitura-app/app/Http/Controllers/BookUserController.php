<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookUserController extends Controller
{
    public function addBookToReadingList(Request $request){

        $bookId = $request->idBook;  

        // Lógica para adicionar o livro à lista de leitura
        // Exemplo: Adicionando o livro ao usuário autenticado
        //$user = auth()->user();
        //$user->readingList()->attach($bookId);  // Supondo que você tenha uma relação many-to-many com o modelo Book

        return response()->json("deu boa");
    }
}
