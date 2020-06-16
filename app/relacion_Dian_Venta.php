<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class relacion_Dian_Venta extends Model
{
    protected $table = 'relacion_Dian_Venta';
    
    protected $primaryKey = 'idrelacion_Dian_Venta';
    public $timestamps=false;
    protected $fillable =
    [
        'relacion_Dian_Ventacol',
        'relacion_Dian_Resolucion',
    ];
    protected $guarded = [
    ];
}
