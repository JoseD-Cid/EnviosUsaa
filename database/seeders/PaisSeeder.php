<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('paises')->insert([
            ['CodPais' => 484, 'Nombre' => 'México'],
            ['CodPais' => 320, 'Nombre' => 'Guatemala'],
            ['CodPais' => 222, 'Nombre' => 'El Salvador'],
            ['CodPais' => 340, 'Nombre' => 'Honduras'],
            // Puedes añadir más países con sus respectivos códigos ISO numéricos
        ]);
    }
}
