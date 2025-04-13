<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class formaContacto extends Model
{
    use HasFactory;
    protected $table= "formacontacto";

    protected $fillable = [
        'formadeContacto',
        'infodelete_Forma',
    ];
}
