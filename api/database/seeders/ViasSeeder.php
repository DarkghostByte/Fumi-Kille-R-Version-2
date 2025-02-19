<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class ViasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('vias')->insert([
            'tipoVia'=>'Calle',
            'infodelete_Vias'=>'Alta',
        ]);
        DB::table('vias')->insert([
            'tipoVia'=>'Callejon',
            'infodelete_Vias'=>'Alta',
        ]);
        DB::table('vias')->insert([
            'tipoVia'=>'Avenida',
            'infodelete_Vias'=>'Alta',
        ]);
    }
}
