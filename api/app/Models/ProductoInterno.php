<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoInterno extends Model
{
    use HasFactory;
    protected $table= "productosinternos";

    protected $fillable = [
        'productoInt',
        'infodelete_productoInt'
    ];
}
