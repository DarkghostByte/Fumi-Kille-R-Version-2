<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    use HasFactory;
    protected $table= "orden";

    protected $fillable = [
        'id_cliente',
        'id_plague1',
        'id_plague2',
        'date1',
        'date2',
        'time1',
        'time2',
        'hiring',
        'infoorden_delete',
        'infoorden_certificate',
        'infoorden_remision',
        'infoorden_facturacion',
        'infoorden_cell',
        'statusOrder',
        'nDosis',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }
}
