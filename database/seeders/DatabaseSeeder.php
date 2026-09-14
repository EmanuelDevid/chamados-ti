<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Garante que o usuário só é criado se não existir no banco
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('12345678'),
            ]
        );

        // Roda o seeder dos Setores, Tipos e Subtipos da SEDHAS
        $this->call([
            HelpdeskSeeder::class,
        ]);
    }
}