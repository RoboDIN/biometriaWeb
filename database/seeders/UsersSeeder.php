<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Exemplo de criação de instâncias de usuários
        DB::table('users')->insert([
            [
                'email' => 'usuario1@example.com',
                'name' => 'Usuário 1',
                'advisor' => 'Orientador 1',
                'entry_date' => '2023-01-01',
                'genre' => 'Masculino',
                'is_admin' => false,
                'password' => Hash::make('senha123'), // Senha criptografada
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'usuario2@example.com',
                'name' => 'Usuário 2',
                'advisor' => 'Orientador 2',
                'entry_date' => '2023-02-01',
                'genre' => 'Feminino',
                'is_admin' => true,
                'password' => Hash::make('senha123'), // Senha criptografada
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}