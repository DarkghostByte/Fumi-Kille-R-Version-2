<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class ColoniaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Nuevo Casas Grandes 
        DB::table('colonias')->insert([
            'colonia'=>'1ro de Mayo',
            'codigoPostal'=>'31735',
            'id_ciudad'=>1,
        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Accion Popular',
            'codigoPostal'=>'31778',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Aeropuerto',
            'codigoPostal'=>'31780',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Alamedas',
            'codigoPostal'=>'31704',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Alamos',
            'codigoPostal'=>'31710',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Ampliacion Zapata',
            'codigoPostal'=>'31777',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Arboledas',
            'codigoPostal'=>'31704',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Benito Juarez',
            'codigoPostal'=>'31770',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Buena Fe',
            'codigoPostal'=>'31806',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Burócrata',
            'codigoPostal'=>'31750',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Campo Catorce (El Capulín)',
            'codigoPostal'=>'31803',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Campo Cinco (El Capulín)',
            'codigoPostal'=>'31803',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Campo Cuatro (El Capulín)',
            'codigoPostal'=>'31803',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Campo Diez (El Capulín)',
            'codigoPostal'=>'31803',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Campo Nueve (El Capulín)',
            'codigoPostal'=>'31803',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Campo  Seis (El Capulín)',
            'codigoPostal'=>'31803',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Campo Siete (El Capulín)',
            'codigoPostal'=>'31803',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Campo Tres (El Capulín)',
            'codigoPostal'=>'31803',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Che Guevara',
            'codigoPostal'=>'31735',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Colinas del Sur',
            'codigoPostal'=>'31780',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Constitución Democratica',
            'codigoPostal'=>'31780',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'División del Norte',
            'codigoPostal'=>'31755',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Dublán',
            'codigoPostal'=>'31710',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Fiesta Diamante',
            'codigoPostal'=>'31750',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Francisco I. Madero',
            'codigoPostal'=>'31807',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Francisco Villa',
            'codigoPostal'=>'31778',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Hacienda San Isidro',
            'codigoPostal'=>'31730',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Héroes de la Reforma',
            'codigoPostal'=>'31777',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Hidalgo (Ejido)',
            'codigoPostal'=>'31803',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Industrial',
            'codigoPostal'=>'31760',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'INFONAVIT Cobra',
            'codigoPostal'=>'31730',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'INFONAVIT Paquimé C.T.M',
            'codigoPostal'=>'31755',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Jardines de Nuevo Casas Grandes',
            'codigoPostal'=>'31778',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Juan José Salas',
            'codigoPostal'=>'31789',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Juan Pablo II',
            'codigoPostal'=>'31704',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'La Rinconada',
            'codigoPostal'=>'31777',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'La Victoria',
            'codigoPostal'=>'31730',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Lagunas',
            'codigoPostal'=>'31780',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Los Arcos',
            'codigoPostal'=>'31720',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Los Encinos',
            'codigoPostal'=>'31770',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Lucio Cabañas',
            'codigoPostal'=>'31758',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Luis Donaldo Colosio',
            'codigoPostal'=>'31758',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Magisterial',
            'codigoPostal'=>'31780',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Miguel Angel Escárcega',
            'codigoPostal'=>'31780',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Misiones',
            'codigoPostal'=>'31783',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Nadadores',
            'codigoPostal'=>'31780',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Nogalera',
            'codigoPostal'=>'31720',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Nueva',
            'codigoPostal'=>'31750',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Nueva Dublan',
            'codigoPostal'=>'31719',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Centro',
            'codigoPostal'=>'31700',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Nuevo Triunfo',
            'codigoPostal'=>'31758',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Obrera',
            'codigoPostal'=>'31750',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Parque Industrial Paquimé',
            'codigoPostal'=>'31755',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Praderas del Oriente',
            'codigoPostal'=>'31704',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'PRI',
            'codigoPostal'=>'31780',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Real del Bosque',
            'codigoPostal'=>'31780',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Regidores',
            'codigoPostal'=>'31780',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'San Isidro',
            'codigoPostal'=>'31730',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'San Pedro Corralitos',
            'codigoPostal'=>'31810',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Sección Hidalgo',
            'codigoPostal'=>'31803',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Tierra y Libertad',
            'codigoPostal'=>'31778',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Villa Hermosa',
            'codigoPostal'=>'31770',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Villas del Tecnologico',
            'codigoPostal'=>'31783',
            'id_ciudad'=>1,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Vistas del Sol',
            'codigoPostal'=>'31730',
            'id_ciudad'=>1,

        ]);

        // Casas Grandes
        DB::table('colonias')->insert([
            'colonia'=>'Anchondo',
            'codigoPostal'=>'31856',
            'id_ciudad'=>2,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'CDP',
            'codigoPostal'=>'31850',
            'id_ciudad'=>2,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Centro',
            'codigoPostal'=>'31850',
            'id_ciudad'=>2,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Cuahtémoc',
            'codigoPostal'=>'31855',
            'id_ciudad'=>2,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'El Adobe',
            'codigoPostal'=>'31861',
            'id_ciudad'=>2,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'El Rucio',
            'codigoPostal'=>'31861',
            'id_ciudad'=>2,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'García',
            'codigoPostal'=>'31860',
            'id_ciudad'=>2,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Granjas',
            'codigoPostal'=>'31850',
            'id_ciudad'=>2,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Guadalupe Victoria',
            'codigoPostal'=>'31851',
            'id_ciudad'=>2,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Hernández (Jobales)',
            'codigoPostal'=>'31860',
            'id_ciudad'=>2,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Heroína',
            'codigoPostal'=>'31863',
            'id_ciudad'=>2,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Ignacio  Zaragoza (El Willy)',
            'codigoPostal'=>'31858',
            'id_ciudad'=>2,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Industrial',
            'codigoPostal'=>'31850',
            'id_ciudad'=>2,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Juan Mata Ortiz (Pearson)',
            'codigoPostal'=>'31861',
            'id_ciudad'=>2,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Colonia Juarez',
            'codigoPostal'=>'31857',
            'id_ciudad'=>2,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'La Esperanza',
            'codigoPostal'=>'31850',
            'id_ciudad'=>2,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Lindavista',
            'codigoPostal'=>'31850',
            'id_ciudad'=>2,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Los Altos',
            'codigoPostal'=>'31850',
            'id_ciudad'=>2,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Moctezuma',
            'codigoPostal'=>'31850',
            'id_ciudad'=>2,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Pacheco',
            'codigoPostal'=>'31862',
            'id_ciudad'=>2,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Profesor Garcia Sánchez',
            'codigoPostal'=>'31851',
            'id_ciudad'=>2,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Progreso',
            'codigoPostal'=>'31850',
            'id_ciudad'=>2,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Quebale',
            'codigoPostal'=>'31858',
            'id_ciudad'=>2,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'San Antonio',
            'codigoPostal'=>'31850',
            'id_ciudad'=>2,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'San Diego',
            'codigoPostal'=>'31857',
            'id_ciudad'=>2,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'San José',
            'codigoPostal'=>'31850',
            'id_ciudad'=>2,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'San José del Sur',
            'codigoPostal'=>'31854',
            'id_ciudad'=>2,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Santa Rosa',
            'codigoPostal'=>'31861',
            'id_ciudad'=>2,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Sección el Oro',
            'codigoPostal'=>'31859',
            'id_ciudad'=>2,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Sección Enríquez',
            'codigoPostal'=>'31854',
            'id_ciudad'=>2,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Vicente Guerrero (Valle Seco)',
            'codigoPostal'=>'31858',
            'id_ciudad'=>2,

        ]);


        // Galeana
        DB::table('colonias')->insert([
            'colonia'=>'Lagunitas',
            'codigoPostal'=>'31870',
            'id_ciudad'=>3,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Galeana',
            'codigoPostal'=>'31870',
            'id_ciudad'=>3,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'San Joaquín',
            'codigoPostal'=>'31874',
            'id_ciudad'=>3,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Angostura',
            'codigoPostal'=>'31870',
            'id_ciudad'=>3,

        ]);
        DB::table('colonias')->insert([
            'colonia'=>'Santa Fe',
            'codigoPostal'=>'31870',
            'id_ciudad'=>3,

        ]);


    }
}
