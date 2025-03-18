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

    // Mutator para a senha (garante que a senha será criptografada antes de salvar)
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value); // Criptografa a senha com bcrypt
    }

    public function setBiometryAttribute($value)
    {
        // Se o valor recebido for Base64 (string), converta-o para binário antes de armazenar
        if (is_string($value)) {
            $this->attributes['biometry'] = base64_decode($value);
        } else {
            // Caso o valor já esteja em binário, só armazene diretamente
            $this->attributes['biometry'] = $value;
        }
    }

    // Getter para converter a biometria em Base64 antes de exibir (se necessário)
    public function getBiometryAttribute($value)
    {
        // Se quiser enviar os dados como Base64 para o frontend, faça a conversão aqui
        return base64_encode($value);
    }
}
