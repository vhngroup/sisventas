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
    'idproyecto',
	'fecha_hora',
	'total_venta',
    'estado',
	'condiciones',
    'fecha_hora',
    ];

    protected $guarded = [
    ]; 
}
