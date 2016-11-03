<?php

namespace sisventas\Http\Controllers;

use Illuminate\Http\Request;
use sisventas\Http\Requests;
use sisventas\banco;
use Illuminate\Support\Facades\Redirect;
use sisventas\Http\Requests\CuentaFormRequest;
use DB;

class CuentaController extends Controller
{
    public function __construct()
    {

		$this->middleware('auth');
    }

    public function index(Request $request)
    {
    	if($request)
    	{
    		$query=trim($request->GET('searchText'));
    		$cuenta=DB::table('cuenta')
    		->where('idcuenta','LIKE','%'.$query.'%')
    		->orderBy('idPersona','desc')
    		->paginate(7);
    		return view('ventas.cliente.index',["cuenta"=>$cuenta,"searchText"=>$query]);
    	}

    }
    public function create()
    {
		return view("banco.create");
    }

    public function store (CuentaFormRequest $request)
    {
		$cuenta =new cuenta;
		$cuenta ->idbanco=$request->get('nombre');
		$cuenta ->idtipodecuenta=$request->get('tipo_documento');
		$cuenta ->numerodecuenta=$request->get('num_documento');
		$cuenta ->idpersona=$request->get('idpersona');
		$cuenta ->save();
		return Redirect::to('ventas/cliente');
    }

    public function show($id)
    {
		return view("ventas.cliente.show",["cuenta"=>Cuenta::findOrFail($id)]);
    }

	public function edit($id)
	{
	return view("ventas.cliente.edit",["cuenta"=>Cuenta::findOrFail($id)]);
	}

	public function update(CuentaFormRequest $request, $id)
	{
		$cuenta =Cuenta::findOrFail($id);
		$cuenta ->idbanco=$request->get('nombre');
		$cuenta ->idtipodecuenta=$request->get('tipo_documento');
		$cuenta ->numerodecuenta=$request->get('num_documento');
		$cuenta ->idpersona=$request->get('idpersona');
		$cuenta ->update();
		return Redirect::to('ventas/cliente');
	}

	public function destroy($id)
	{
	$persona=Persona::findOrFail($id);
	$persona->cuenta='No';
	$persona>update();
	return Redirect::to('ventas/cliente');
	}
}
