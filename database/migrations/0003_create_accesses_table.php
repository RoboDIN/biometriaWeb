<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('accesses', function (Blueprint $table) {
            $table->id('cod_access'); // Chave primária autoincrementável
            $table->string('id_email', 100); // Chave estrangeira para o email do usuário
            $table->date('data'); // Data do acesso
            $table->time('hora'); // Hora do acesso
            $table->timestamps(); // Colunas created_at e updated_at

            // Chave estrangeira referenciando a tabela usuarios
            $table->foreign('id_email')
                  ->references('cod_email')
                  ->on('members')
                  ->onDelete('cascade'); // Se o usuário for deletado, seus acessos também serão
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accesses');
    }
};
