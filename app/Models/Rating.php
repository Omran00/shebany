<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = ['rate','session_id','student_id','subject_id'];

    public $timestamps = false;
    
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
    
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function session()
    {
        return $this->belongsTo(Session::class);
    }
}
