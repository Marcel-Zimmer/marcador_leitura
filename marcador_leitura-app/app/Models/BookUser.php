<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookUser extends Model
{
    protected $fillable = ['id_book','id_user','status'];
    protected $table = 'books_user';

    public static function createNewInstance(int $idBook, int $idUser, string $status){
        return static::create([
            'id_book' => $idBook, 
            'id_user' => $idUser,
            'status' => $status,
        ]);
    }

}
