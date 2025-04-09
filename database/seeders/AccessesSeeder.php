<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AccessesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            'admin1@example.com', 'admin2@example.com', 'admin3@example.com', 'admin4@example.com',
            'usuario5@example.com', 'usuario6@example.com', 'usuario7@example.com', 'usuario8@example.com',
            'usuario9@example.com', 'usuario10@example.com'
        ];

        $startDate = Carbon::now()->subMonth(); // Começa há um mês atrás
        $endDate = Carbon::now(); // Até a data atual

        $accesses = [];

        foreach ($users as $email) {
            $days = rand(10, 20); // Cada usuário tem entre 10 e 20 registros
            for ($i = 0; $i < $days; $i++) {
                $randomDate = Carbon::createFromTimestamp(rand($startDate->timestamp, $endDate->timestamp));
                $accesses[] = [
                    'id_email' => $email,
                    'data' => $randomDate->toDateString(),
                    'hora' => $randomDate->format('H:i:s'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('accesses')->insert($accesses);
    }
}
