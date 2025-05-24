<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookUser extends Model
{
    protected $fillable = ['id_book','id_user','status'];
    protected $table = 'books_user';

}
