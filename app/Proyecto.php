<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    protected $table = 'proyecto';

    protected $primaryKey = 'idproyecto';

    public $timestamps=false;

    protected $fillable =[
	'idpersona',
	'fecha',
	'descripcion',
	'alerta1',
	'fechaalerta1',
	'alerta2',
	'fechaalerta2',
	'estado',
	'observaciones'
	];
}
