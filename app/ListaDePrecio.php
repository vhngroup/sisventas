<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class ListaDePrecio extends Model
{
    //
    protected $table = 'listaDePrecios';

    protected $primaryKey = 'lista_Id';

    public $timestamps=false;
    protected $fillable =[
    	'id_Proveedor',
    	'Url'
    ];

    protected $guarded = [
    ];

}
