<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProductosInternosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('productosInternos')->insert([
            'productoInt'=>'No aplica',
            'infodelete_productoInt'=>'Alta',
        ]);  
        DB::table('productosInternos')->insert([
            'productoInt'=>'Producto #1',
            'infodelete_productoInt'=>'Alta',
        ]);
        DB::table('productosInternos')->insert([
            'productoInt'=>'Producto #2',
            'infodelete_productoInt'=>'Alta',
        ]);
        DB::table('productosInternos')->insert([
            'productoInt'=>'Producto #3',
            'infodelete_productoInt'=>'Alta',
        ]);  
        DB::table('productosInternos')->insert([
            'productoInt'=>'Producto #4',
            'infodelete_productoInt'=>'Alta',
        ]);  
    }
}