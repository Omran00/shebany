<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $primaryKey = 'admin_id';
    protected $fillable = ['admin_id'];
    public $timestamps = false;
    
    public function user()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
