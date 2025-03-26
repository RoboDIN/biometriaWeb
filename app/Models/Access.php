<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Access extends Model
{
    use HasFactory;

    protected $primaryKey = 'cod_access'; // Define a chave primária
    protected $table = 'accesses'; // Define o nome da tabela

    // Relacionamento com a tabela users
    public function user()
    {
        return $this->belongsTo(User::class, 'id_email', 'email');
    }
}