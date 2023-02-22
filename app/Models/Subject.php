<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = ['name','description'];

    public $timestamps = false;
    
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

}
