<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'orientador',
        'dataEntrada',
        'biometria',
        'sexo',
        'admin',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'name' => 'text',
        'email' => 'text',
        'orientador' => 'text',
        'dataEntrada' => 'date',
        'sexo' => 'text',
        'admin' => 'boolean',
        'password' => 'hashed',
    ];

    // Mutator para a senha (garante que a senha será criptografada antes de salvar)
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value); // Criptografa a senha com bcrypt
    }

    // Mutator para salvar a imagem como base64
    public function setBiometriaAttribute($value)
    {
        if (is_file($value)) {
            $this->attributes['biometria'] = base64_encode(file_get_contents($value)); // Converte para base64
        }
    }

    // Acessor para recuperar a imagem como base64
    public function getBiometriaAttribute($value)
    {
        return $value ? 'data:image/png;base64,' . $value : null; // Retorna como base64 para exibição
    }
}
