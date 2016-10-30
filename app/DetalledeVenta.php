<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class DetalledeVenta extends Model
{
    protected $table = 'detalledeventa';

    protected $primaryKey = 'iddetalledeventa';

    public $timestamps=false;

    protected $fillable =[
	'idventa',
	'idarticulo',
	'cantidad',
	'precio_venta',
	'descuento'
    ];

    protected $guarded = [
    ];
}
