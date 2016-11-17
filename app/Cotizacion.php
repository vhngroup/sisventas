<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    protected $table = 'cotizacion';

    protected $primaryKey = 'idcotizacion';

    public $timestamps=false;

    protected $fillable =[
	'idcliente',
	'tipo_comprobante',
	'serie_comprobante',
	'num_comprobante',
	'fecha_hora',
	'impuesto',
	'total_venta',
	'estado',
	'idproyecto',
	'anticipo',
	'descripccion',
    ];

    protected $guarded = [
    ]; 

     //public function cotizaciones()
    //{
      //  return $this->hasMany('App\User', detallecotizacion, idcotizacion);
    //}
}
