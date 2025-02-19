<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class ComercioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('comercios')->insert([
            'comercio'=>'Administracion',
            'infodelete_departamento'=>'Alta'
        ]);
        DB::table('comercios')->insert([
            'comercio'=>'Ventas',
            'infodelete_departamento'=>'Alta'
        ]);
    }
}
