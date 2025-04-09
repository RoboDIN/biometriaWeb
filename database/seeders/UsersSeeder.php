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
        DB::table('users')->insert([
            [
                'email' => 'admin1@example.com',
                'name' => 'Administrador 1',
                'advisor' => 'Orientador A',
                'entry_date' => '2023-01-01',
                'genre' => 'Masculino',
                'is_admin' => true,
                'password' => Hash::make('admin123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'admin2@example.com',
                'name' => 'Administrador 2',
                'advisor' => 'Orientador B',
                'entry_date' => '2023-02-01',
                'genre' => 'Feminino',
                'is_admin' => true,
                'password' => Hash::make('admin123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'admin3@example.com',
                'name' => 'Administrador 3',
                'advisor' => 'Orientador C',
                'entry_date' => '2023-03-01',
                'genre' => 'Outro',
                'is_admin' => true,
                'password' => Hash::make('admin123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'admin4@example.com',
                'name' => 'Administrador 4',
                'advisor' => 'Orientador D',
                'entry_date' => '2023-04-01',
                'genre' => 'Masculino',
                'is_admin' => true,
                'password' => Hash::make('admin123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'usuario5@example.com',
                'name' => 'Usuário 5',
                'advisor' => 'Orientador E',
                'entry_date' => '2023-05-01',
                'genre' => 'Feminino',
                'is_admin' => false,
                'password' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'usuario6@example.com',
                'name' => 'Usuário 6',
                'advisor' => 'Orientador F',
                'entry_date' => '2023-06-01',
                'genre' => 'Masculino',
                'is_admin' => false,
                'password' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'usuario7@example.com',
                'name' => 'Usuário 7',
                'advisor' => 'Orientador G',
                'entry_date' => '2023-07-01',
                'genre' => 'Outro',
                'is_admin' => false,
                'password' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'usuario8@example.com',
                'name' => 'Usuário 8',
                'advisor' => 'Orientador H',
                'entry_date' => '2023-08-01',
                'genre' => 'Feminino',
                'is_admin' => false,
                'password' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'usuario9@example.com',
                'name' => 'Usuário 9',
                'advisor' => 'Orientador I',
                'entry_date' => '2023-09-01',
                'genre' => 'Masculino',
                'is_admin' => false,
                'password' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'usuario10@example.com',
                'name' => 'Usuário 10',
                'advisor' => 'Orientador J',
                'entry_date' => '2023-10-01',
                'genre' => 'Feminino',
                'is_admin' => false,
                'password' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
