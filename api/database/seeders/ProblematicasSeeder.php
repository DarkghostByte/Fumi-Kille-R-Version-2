<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProblematicasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('problematicas')->insert([
            'problematica'=>'No aplica',
            'infodelete_problematica'=>'Alta',
        ]);
        DB::table('problematicas')->insert([
            'problematica'=>'Cucarachas',
            'infodelete_problematica'=>'Alta',
        ]);
        DB::table('problematicas')->insert([
            'problematica'=>'Pulgas',
            'infodelete_problematica'=>'Alta',
        ]);
        DB::table('problematicas')->insert([
            'problematica'=>'Chinches',
            'infodelete_problematica'=>'Alta',
        ]);
        DB::table('problematicas')->insert([
            'problematica'=>'Cucaracha de cocina',
            'infodelete_problematica'=>'Alta',
        ]);
        DB::table('problematicas')->insert([
            'problematica'=>'Garrapatas',
            'infodelete_problematica'=>'Alta',
        ]);
        DB::table('problematicas')->insert([
            'problematica'=>'Palomillas',
            'infodelete_problematica'=>'Alta',
        ]);
        DB::table('problematicas')->insert([
            'problematica'=>'Roedores',
            'infodelete_problematica'=>'Alta',
        ]);
        DB::table('problematicas')->insert([
            'problematica'=>'Hormigas',
            'infodelete_problematica'=>'Alta',
        ]);
    }
}
