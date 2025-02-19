<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompletarOrden extends Model
{
    use HasFactory;
    protected $table= "completarOrdenes";

    protected $fillable = [
        'id_orden',
        'responsable',
        'ayudante',
        'id_empleado',
        'id_empleado2',
        'id_productosInternos',
        'id_productosInternos2',
        'id_productosExternos',
        'id_productosExternos2',
        'noTrapear',
        'noIngresar',
        'otraDosis',
        'pago',
        'requiere1',
        'requiere2',
        'requiere3',
        'requiere4',
        'facturaOrden',
    ];
}

