<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = ['first_name', 'image', 'class', 'score', 'father_id', 'teacher_id', 'is_approved'];

    protected $hidden =
    [
        'laravel_through_key',
        'is_approved'
    ];
    public $timestamps = false;

    public function father()
    {
        return $this->belongsTo(Father::class, 'father_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function books()
    {
        return $this->belongsToMany(Book::class, 'favorite_books', 'id', 'book_id');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function last_name()
    {
        return $this->hasOneThrough(User::class, Father::class, 'father_id', 'id', 'id', 'father_id')->select('last_name');
    }
}
