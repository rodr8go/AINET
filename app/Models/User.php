<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name', 'email', 'password', 'user_type', 'gender', 'blocked', 'photo_url', 'custom',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'blocked' => 'integer',
        'custom' => 'array',
    ];

    // Para bater certo com o "1" para "N" do diagrama, usamos hasMany:
    public function customers()
    {
        return $this->hasMany(Customer::class, 'id', 'id');
    }
}