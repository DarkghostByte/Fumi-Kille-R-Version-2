<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class CiudadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ciudades')->insert([
            'ciudad'=>'Nuevo Casas Grandes',
            'estado'=>'Chihuahua',
            'infodelete_Ciudad'=>'Alta',
        ]);
        DB::table('ciudades')->insert([
            'ciudad'=>'Casas Grandes',
            'estado'=>'Chihuahua',
            'infodelete_Ciudad'=>'Alta',
        ]);
        DB::table('ciudades')->insert([
            'ciudad'=>'Galeana',
            'estado'=>'Chihuahua',
            'infodelete_Ciudad'=>'Alta',
        ]);  
    }
}
