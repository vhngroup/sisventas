<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    protected $table = 'cotizacion';

    protected $primaryKey = 'idcotizacion';

    public $timestamps=false;

    protected $fillable =[
    'fecha_hora',	
	'idcliente',
	'serie_comprobante',
	'num_comprobante',
	'descripcion',
	'impuesto',
	'total_general',
	'total_descuento',
	'subtotal',
	'valoriva',
	'total_venta',
	'estado',
	'idproyecto',
	'condiciones'	
    ];

    protected $guarded = [
    ]; 

     //public function cotizaciones()
    //{
      //  return $this->hasMany('App\User', detallecotizacion, idcotizacion);
    //}
}
