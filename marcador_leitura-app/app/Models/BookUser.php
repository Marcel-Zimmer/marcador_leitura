<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookUser extends Model
{
    protected $fillable = ['id','id_user', 'id_book', 'note', 'status', 'resume'];
    protected $table = 'books_user';
}
