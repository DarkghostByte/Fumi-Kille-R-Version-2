<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleados extends Model
{
    use HasFactory;
    protected $table= "empleados";

    protected $fillable = [
        'nameEmpleado',
        'lastnameEmpleado1',
        'lastnameEmpleado2',
        'ariasEmpleado',
        'infodelete_Empleados',
        'id_departamento'
    ];
}
