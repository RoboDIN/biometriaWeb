<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'users'; // Nome da tabela no banco de dados
    
    protected $fillable = [
        'email',
        'name',
        'advisor',
        'entry_date',
        'biometry',
        'genre',
        'admin',
        'password',
    ];

    protected $hidden = [
        'password',
        'biometry',
    ];

    protected $casts = [
        'entry_date' => 'date',
        'admin' => 'boolean',
        'password' => 'hashed',
    ];

    // Define o campo `email` como chave primária
    protected $primaryKey = 'email';

    // Desativa o comportamento de auto-incremento
    public $incrementing = false;

    // Define o tipo do campo primário como string
    protected $keyType = 'string';

    // Mutator para a senha (garante que a senha será criptografada antes de salvar)
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value); // Criptografa a senha com bcrypt
    }

    // Mutator para salvar a imagem como base64
    // public function setBiometriaAttribute($value)
    // {
    //     if (is_file($value)) {
    //         $this->attributes['biometry'] = base64_encode(file_get_contents($value)); // Converte para base64
    //     }
    // }

    // // Acessor para recuperar a imagem como base64
    // public function getBiometriaAttribute($value)
    // {
    //     return $value ? 'data:image/png;base64,' . $value : null; // Retorna como base64 para exibição
    // }
}
