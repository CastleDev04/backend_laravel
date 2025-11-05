<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // ✅ CAMBIO 1: Especificar la tabla
    protected $table = 'usuarios';

    // ✅ CAMBIO 2: Quitar campos que no existen en tu tabla
    protected $fillable = [
        'nombre',
        'email',
        'password',
        'rol',
    ];

    protected $hidden = [
        'password',
        // 'remember_token', // ❌ QUITAR - no existe en tu tabla
    ];

    protected $casts = [
        // 'email_verified_at' => 'datetime', // ❌ QUITAR - no existe en tu tabla
    ];
}