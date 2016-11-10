<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categoria';

    protected $primaryKey = 'idcategoria';

    public $timestamps=false;

    protected $fillable =[
	'Nombre',
	'Descripccion',
	'Condicion'
    ];

    protected $guarded = [
    ]; 
}
