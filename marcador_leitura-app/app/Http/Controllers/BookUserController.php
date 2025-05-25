<?php

namespace App\Http\Controllers;

use App\Models\BookUser;
use App\Models\Book;
use Illuminate\Http\Request;

class BookUserController extends Controller
{

    //função para adicionar um livro a lista de livros a ler
    public function addBookToReadingList(Request $request){ 
        $userID = auth()->user()->id; //recebe o id do usuário logado pelo laravel 
        $book = BookUser::where('id_user', $userID)
        ->where('id_book',$request->idBook)->first();// consulta para verificar se o livro já foi registado 
        if(!$book ){ //o láravel retorna null se não encontrar nada no caso do firsty
            $newBookToReading = new BookUser(); //construção de uma nova instancia de BookUser
            $newBookToReading->id_book = $request->idBook;   //id do livro
            $newBookToReading->id_user = $userID; //id do usuário
            $newBookToReading->note = 0; //nota que a principio será zero
            $newBookToReading->status = "Reading"; //status de leitura 
            $newBookToReading->resume = ""; //resumo gerado por IA
            $newBookToReading->save(); // comando para salvar no banco de dados
            return response()->json($newBookToReading); //retorno da função 
        }
        else{
            return response()->json('livro já foi adicionado'); //retorno da função caso o livro já tenha sido registrado
        }
    }
    //função para adicionar um livro a lista de lidos 
    public function addBookToReadList(Request $request){
        $userID = auth()->user()->id; //recebe o id do usuário pelo laravel
        $book = BookUser::where('id_user', $userID)
        ->where('id_book',$request->idBook)->first(); //verifica se já existe algum registro do usuário com o livro
        if(!$book ){ //em caso negativo entra no if 
            $newBookToReading = new BookUser(); // cria uma nova instancia 
            $newBookToReading->id_book = $request->idBook;  //id do livro
            $newBookToReading->id_user = $userID ; // id do usuário
            $newBookToReading->note = 0; //nota 
            $newBookToReading->status = "Read"; //status de leitura   
            $newBookToReading->resume = ""; //resumo gerado por IA 
            $newBookToReading->save(); // comando para salvar no bd
            return response()->json($newBookToReading); //retorna o livro caso tudo tenha dado certo
        }else{ 
            return response()->json("livro já foi adicionado"); // função retorna que o livro já foi lido 
        }
    }

    //função que busca no banco de dados todos os livros que o usuário quer ler 
    public function getBooksToRead(){
        $userID = auth()->user()->id;
        $ListBookUser = BookUser::where('id_user', $userID)->where('status','Reading')->get();
        $books = [];
        foreach ($ListBookUser as $BookUser) {
            $newBook = Book::find($BookUser->id_book);
            $books[] = $newBook;
        }
        return response()->json($books);
    }
    //função que busca no banco de dados todos os livros que o usuário já leu 
    public function getBooksRead(){
        $userID = auth()->user()->id;
        $ListBookUser = BookUser::select('id')->where('id_user', $userID)->where('status','Read')->get();
        $books = [];
        foreach ($ListBookUser as $BookUser) {
            $newBook = Book::find($BookUser->id_book);
            $books[] = $newBook;
        }
        return response()->json($books);
    }
    //função que permite remover o livro da lista de livros lidos 
    public function removeBookReadList(Request $request){
        $userID = auth()->user()->id;
        $bookUser = BookUser::where('id_user', $userID)->where('id_book',$request->idBook)->where('status','Read')->first();

        $bookUser->delete();
        return response()->json("deu boa");
    }
    //função que permite remover o livro da lista de livros para ler 
    public function removeBookReadingList(Request $request){
        $userID = auth()->user()->id;
        $bookUser = BookUser::where('id_user', $userID)->where('id_book',$request->idBook)->where('status','Reading')->first();

        $bookUser->delete();
        return response()->json("deu boa");
        
    }

    public function updateBookStatusToReading(Request $request){
        $userID = auth()->user()->id;
        $bookUser = BookUser::where("id_user",$userID)->where("id_book",$request->idBook)->first();
        $bookUser->status = "Reading";
        $bookUser->save();
        return response()->json($bookUser);
    }

    public function updateBookStatusToRead(Request $request){
        $userID = auth()->user()->id;
        $bookUser = BookUser::where("id_user",$userID)->where("id_book",$request->idBook)->first();
        $bookUser->status = "Read";
        $bookUser->save();
        return response()->json($bookUser);
    }
}
