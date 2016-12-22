<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = 'pedido';

    protected $primaryKey = 'idpedido';

    public $timestamps=false;

    protected $fillable =[
	'idproveedor',
	'fecha_hora',
	'total_venta',
	'idproyecto',
	'condiciones',
    ];

    protected $guarded = [
    ]; 
}
