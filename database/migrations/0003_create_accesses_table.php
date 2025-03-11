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
            $table->id('cod_access');
            $table->string('id_email', 255); 
            $table->date('data');
            $table->time('hora');
            $table->timestamps();

            // Chave estrangeira referenciando a tabela users
            $table->foreign('id_email')
                  ->references('email')
                  ->on('users');
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