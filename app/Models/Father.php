<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Father extends Model
{
    use HasFactory;

    protected $primaryKey = 'father_id';
    protected $fillable = ['father_id'];

    public $timestamps = false;
    protected $hidden = 
    [
        'laravel_through_key'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'father_id');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'father_id');
    }
}
