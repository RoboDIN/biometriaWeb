<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes;

    protected $table = 'users'; // Nome da tabela no banco de dados
    
    protected $fillable = [
        'email',
        'name',
        'advisor',
        'entry_date',
        'biometry',
        'genre',
        'is_admin',
        'password',
    ];

    protected $hidden = [
        'password',
        'biometry',
    ];

    protected $casts = [
        'entry_date' => 'date',
        'is_admin' => 'boolean',
        'password' => 'hashed',
    ];

    // Define o campo `email` como chave primária
    protected $primaryKey = 'email';

    // Desativa o comportamento de auto-incremento
    public $incrementing = false;

    // Define o tipo do campo primário como string
    protected $keyType = 'string';

}
