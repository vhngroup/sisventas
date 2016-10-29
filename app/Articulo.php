<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
  protected $table = 'articulo';

    protected $primaryKey = 'idarticulo';

    public $timestamps=false;

    protected $fillable =[
	'idcategoria',
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
