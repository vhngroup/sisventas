<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class cuenta extends Model
{
    protected $table = 'cuenta';

    protected $primaryKey = 'idcuenta';

    public $timestamps=false;

    protected $fillable =[
	'idbanco',
	'idtipocuenta',
	'numerodecuenta'
	'idpersona'
    ];

    protected $guarded = [
    ];
}
