<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class EmpleadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('empleados')->insert([
            'nameEmpleado'=>'No aplica',
            'lastnameEmpleado1'=>'No aplica',
            'lastnameEmpleado2'=>'No aplica',
            'ariasEmpleado'=>'No aplica',
            'infodelete_Empleados'=>'Alta',
            'id_departamento'=>'1',
        ]);
        
    }
}
