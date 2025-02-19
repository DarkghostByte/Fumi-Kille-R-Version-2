<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ordenCompra extends Model
{
    use HasFactory;
    protected $table= "ordenCompra";

    protected $fillable = [
        'fechaOrdenCompra',
        'paraOrdenCompra',
        'conceptoOrdenCompra',
        'detalleOrdenCompra',
        'empleadoOrdenCompra',
        'importeOrdenCompra',
        'autorizoOrdenCompra',
    ];

}