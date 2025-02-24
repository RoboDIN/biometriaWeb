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
        Schema::create('members', function (Blueprint $table) {
            $table->string('cod_email', 100)->primary();
            $table->string('name');
            $table->date('entry_date'); // Data de cadastro do usuário
            $table->binary('biometry');
            $table->string('genre');
            $table->boolean('is_adm')->index();
            $table->string('advisor')->nullable();

            //IMPORTANTE: 
            //Verificar como tratar o campo senha para não passar essa informação para o front..
            //OBS: Caso o usuário não seja adm, o campo deve estar vazio, e o usuário não deve ser capaz de fazer login no sistema
            $table->string('password', 60)->nullable();

            $table->timestamps(); // Colunas created_at e updated_at (talvez não precise do campo "entry_date")
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
