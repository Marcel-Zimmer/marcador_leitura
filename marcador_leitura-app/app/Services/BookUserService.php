<?php

namespace App\Services;
use App\Models\BookUser;
  
class BookUserService{

    public function markBookToReadingList(int $idBook){
        return BookUser::updateOrCreate(
            ['id_book' => $idBook, 'id_user' => auth()->id()],
            ['status' => 'READING']
        );
    }

    public function markBookToReadList(int $idBook){
        return BookUser::updateOrCreate(
            ['id_book' => $idBook, 'id_user' => auth()->id()],
            ['status' => 'FINISHED']
        );
    }
    public function getBooksNotFinished(){
        return BookUser::where('id_user', auth()->id())
                     ->where('status', 'READING')
                     ->pluck('id')
                     ->toArray();
    }

    public function getBooksFinished(){
        return BookUser::where('id_user', auth()->id())
                     ->where('status', 'FINISHED')
                     ->pluck('id')
                     ->toArray();
    }
}

