<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Remisiones extends Model
{
    use HasFactory;

    protected $table= "remisiones";

    protected $fillable = [
        'id_cliente',
        'RemisionDate',
        'RemisionCertificado',
        'RemisionMonto',
        'RemisionObservaciones',
    ];
}
