<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class FormaContactoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('formaContacto')->insert([
            'formadeContacto'=>'Barda',
            'infodelete_Forma'=>'Alta',
        ]);
        DB::table('formaContacto')->insert([
            'formadeContacto'=>'Facebook',
            'infodelete_Forma'=>'Alta',
        ]);
        DB::table('formaContacto')->insert([
            'formadeContacto'=>'Telefono',
            'infodelete_Forma'=>'Alta',
        ]);
    }
}
