<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vias extends Model
{
    use HasFactory;
    protected $table= "vias";

    protected $fillable = [
        'tipoVia',
        'infodelete_Vias',
    ];}
