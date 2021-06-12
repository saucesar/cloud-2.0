<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $fillable = ['name', 'email', 'password', 'phone', 'category_id', 'user_type'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['email_verified_at' => 'datetime'];

    public function machines()
    {
        return $this->hasMany(Maquina::class);
    }

    public function containers()
    {
        return $this->hasMany(Container::class);
    }

    public function isAdmin()
    {
        return $this->user_type == 'admin';
    }

    public function category()
    {
        return $this->hasOne('App\Models\UserCategory', 'id', 'category_id');
    }

    public function volumes()
    {
        return $this->hasMany(Volume::class);
    }
}
