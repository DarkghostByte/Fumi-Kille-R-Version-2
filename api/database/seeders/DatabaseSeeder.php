<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(ClientesSeeder::class);
        $this->call(OrdensSeeder::class);
        $this->call(CiudadSeeder::class);
        $this->call(ColoniaSeeder::class);
        $this->call(CompletarOrdenSeeder::class);
        $this->call(ComercioSeeder::class);
        $this->call(ProductosInternosSeeder::class);
        $this->call(ProductosExternosSeeder::class);
        $this->call(EmpleadosSeeder::class);
        $this->call(ViasSeeder::class);
        $this->call(ProblematicasSeeder::class);
        $this->call(OrdenCompraSeeder::class);
        $this->call(FormaContactoSeeder::class);
    }
}
