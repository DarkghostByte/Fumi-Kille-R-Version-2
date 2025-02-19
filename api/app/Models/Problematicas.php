<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Problematicas extends Model
{
    use HasFactory;
    protected $table= "problematicas";

    protected $fillable = [
        'problematica',
        'infodelete_problematica'
    ];
}
