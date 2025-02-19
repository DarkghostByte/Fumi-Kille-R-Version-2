<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'lastname1',
        'lastname2',
        'tradename',
        'id_vias',
        'home',
        'numAddress',
        'id_colonia',
        'id_city',
        'comercio',
        'description',
        'how_to_get',
        'cell_phone',
        'number_fixed_number',
        'contact_form',
        'specify',
        'recruitment_data',
        'infoclient_delete',
        'requires',
        'correo',
    ];
}
