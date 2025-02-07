<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
public function serchaBookByName($name)
    {
        // Cria uma instância do modelo Book e faz a pesquisa
        $bookModel = new Book();
        $books = $bookModel->searchBooks($name);

        // Verifica se foram encontrados livros
        if (count($books) > 0) {
            // Se houver livros, cria um array de dados formatados para resposta
            $formattedBooks = [];

            foreach ($books as $book) {
                // Acessa os dados de cada livro
                $formattedBooks[] = [
                    'title' => $book->title,
                    'imagemLink' => $book->imagemLink
                ];
            }

            // Retorna os dados formatados como JSON
            return response()->json($formattedBooks);

        }

        // Se não encontrar livros, retorna uma mensagem dizendo que não há resultados
        return response()->json(['message' => 'Nenhum livro encontrado.'], 404);
    }
}
