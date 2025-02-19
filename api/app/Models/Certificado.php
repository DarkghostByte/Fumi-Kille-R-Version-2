<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificado extends Model
{
    use HasFactory;

    protected $table= "certificados";

    protected $fillable = [
        'id_orden',
        'certificateName',
        'id_productoCertificadoInt1',
        'id_productoCertificadoExt1',
    ];
}
