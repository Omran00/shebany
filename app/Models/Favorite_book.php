<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Favorite_book extends Pivot
{
    use HasFactory;

    protected $primaryKey = 'id';

    public $timestamps = false;
    
    protected $table = 'favorite_books';

}
