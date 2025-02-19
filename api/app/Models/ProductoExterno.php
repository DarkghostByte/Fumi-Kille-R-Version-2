<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoExterno extends Model
{
    use HasFactory;
    protected $table= "productosExternos";

    protected $fillable = [
        'productoExt',
        'infodelete_productoExt'
    ];
}
