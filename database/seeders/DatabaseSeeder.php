<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Cidade;
use App\Models\Medico;
use App\Models\Paciente;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Cidade::factory(10)->has(
            Medico::factory(3)->has(
                Paciente::factory(2)
            )
        )->create();
    }
}
