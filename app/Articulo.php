<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
  protected $table = 'articulo';

    protected $primaryKey = 'idArticulo';

    public $timestamps=false;

    protected $fillable =[
	'idCategoria',
	'codigo',
	'nombre',
	'stock',
	'descripccion',
	'imagen',
	'estado'
    ];

    protected $guarded = [
    ];
}
