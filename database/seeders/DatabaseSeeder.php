<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Cidade;
use App\Models\Medico;
use App\Models\Paciente;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Christian Ramires',
            'email' => 'christian.ramires@example.com',
            'password' => Hash::make('password')
        ]);

        $user->createToken("access_token");

        Cidade::factory(20)->has(
            Medico::factory(10)->has(
                Paciente::factory(5)
            )
        )->create();
    }
}
