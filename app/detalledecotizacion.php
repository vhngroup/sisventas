<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class detalledecotizacion extends Model
{
   protected $table = 'detallecotizacion';

    protected $primaryKey = 'iddetallecotizacion';

    public $timestamps=false;

    protected $fillable =[
	'idcotizacion',
	'idarticulo',
	'cantidad',
	'precio_venta',
	'descuento'
    ];
}
