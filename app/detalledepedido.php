<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class detalledepedido extends Model
{
     protected $table = 'detalledepedido';

    protected $primaryKey = 'iddetalledepedido';

    public $timestamps=false;

    protected $fillable =[
	'idpedido',
	'idarticulo',
	'cantidad',
	'precio_venta',
	'descuento'
    ];

    protected $guarded = [
    ];
}
