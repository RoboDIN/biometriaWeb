<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {

            $table->string('email')->primary();
            $table->string('name');
            $table->string('advisor'); 
            $table->timestamp('entry_date')->nullable();
            $table->binary('biometry')->nullable(); 
            $table->string('genre'); 
            $table->boolean('admin')->default(false); 
            $table->string('password')->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
