<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccessesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Exemplo de criação de instâncias de accesses
        DB::table('accesses')->insert([
            [
                'id_email' => 'usuario1@example.com', // Email de um usuário existente na tabela users
                'data' => '2023-10-01',
                'hora' => '08:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_email' => 'usuario2@example.com', // Email de outro usuário existente na tabela users
                'data' => '2023-10-02',
                'hora' => '09:30:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
