<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = ['date','teacher_id'];

    public $timestamps = false;

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function teacher()
    {
        return $this->hasOneThrough(User::class, Teacher::class, 'teacher_id', 'id', 'teacher_id', 'teacher_id');
    }
}
