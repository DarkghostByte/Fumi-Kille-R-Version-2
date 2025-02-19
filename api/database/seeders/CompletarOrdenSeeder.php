<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CompletarOrdenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
        DB::table('completarOrdenes')->insert([
            'id_orden'=>'1',
            'responsable'=>'Luis Angel Peña Mora',
            'ayudante'=>'Nadien',
            'productoInt1'=>'Simon',
            'productoInt2'=>'Ninguno',
            'productoExt1'=>'Simon',
            'productoExt2'=>'Ninguno',
            'noTrapear'=>'Nose',
            'noIngresar'=>'Nose',
            'otraDosis'=>'Nose',
            'hora'=>'Nose',
            'pago'=>'500.00',
            'requiere1'=>'Nada',
            'requiere2'=>'Nada',
        ]);  
        */
    }
}
