<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Access extends Model
{
    use HasFactory;

    // Nome da tabela no banco de dados
    protected $table = 'accesses';

    // Chave primária da tabela
    protected $primaryKey = 'cod_access';

    // Indica se a chave primária é autoincrementável
    public $incrementing = true;

    // Ativa os timestamps (created_at e updated_at)
    public $timestamps = true;

    // Colunas que podem ser preenchidas em massa (mass assignment)
    protected $fillable = [
        'id_email',
        'data',
        'hora',
    ];
}