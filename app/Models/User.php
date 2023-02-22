<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = ['first_name', 'last_name', 'phone', 'password', 'image', 'role_id', 'is_approved'];
    public $timestamps = false;
    protected $hidden =
    [
        'pivot',
        'laravel_through_key',
        'role',
        'password',
    ];
    public function admin()
    {
        return $this->hasOne(Admin::class, 'admin_id');
    }

    public function teacher()
    {
        return $this->hasOne(Teacher::class, 'teacher_id');
    }

    public function father()
    {
        return $this->hasOne(Father::class, 'father_id');
    }

    public function role()
    {
        return $this->belongsToMany(Role::class, 'user_role', 'user_id', 'role_id')->select('role_id', 'name');
    }
}
