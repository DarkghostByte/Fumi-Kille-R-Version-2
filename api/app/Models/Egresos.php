<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Egresos extends Model
{
    use HasFactory;
    protected $table= "egresos";

    protected $fillable = [
        'dateEgresos',
        'descriptionEgresos',
        'montoEgresos',
        'dataEgresos',
        'id_departamento1'
    ];
}
