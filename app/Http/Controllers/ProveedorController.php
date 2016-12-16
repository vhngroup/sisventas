<?php

namespace sisventas\Http\Controllers;

use Illuminate\Http\Request;

use sisventas\Http\Requests;
use sisventas\Persona;
use Illuminate\Support\Facades\Redirect;
use sisventas\Http\Requests\PersonaformRequest;
use DB;

class ProveedorController extends Controller
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
    		$personas=DB::table('persona')
    		->where('nombre','LIKE','%'.$query.'%')
    		->where('tipo_persona','=','Proveedor')
    		->orwhere('nombrecontacto','LIKE','%'.$query.'%')
    		->where('tipo_persona','=','Proveedor')
    		->orwhere('num_documento','LIKE','%'.$query.'%')
    		->where('tipo_persona','=','Proveedor')
    		->orwhere('telefono','LIKE','%'.$query.'%')
    		->where('tipo_persona','=','Proveedor')
    		->orwhere('Notas','LIKE','%'.$query.'%')
    		->where('tipo_persona','=','Proveedor')
    		->orderBy('idPersona','desc')
    		->paginate(10);
    		return view('compras.proveedor.index',["personas"=>$personas,"searchText"=>$query]);
    	}

    }
    public function create()
    {
		return view("compras.proveedor.create");
    }

    public function store (PersonaformRequest $request)
    {
		$persona =new Persona;
		$persona ->tipo_persona='Proveedor';
		$persona ->nombre=$request->get('nombre');
		$persona ->nombrecontacto=$request->get('nombrecontacto');
		$persona ->tipo_documento=$request->get('tipo_documento');
		$persona ->num_documento=$request->get('num_documento');
		$persona ->direccion=$request->get('direccion');
		$persona ->telefono=$request->get('telefono');
		$persona ->email=$request->get('email');
		$persona ->notas=$request->get('notas');
		$persona ->tipocuenta=$request->get('tipocuenta');
		$persona ->banco=$request->get('banco');
		$persona ->numerodecuenta=$request->get('numerodecuenta');
		$persona ->save();
		return Redirect::to('compras/proveedor');
    }

    public function show($id)
    {
		return view("compras.proveedor.show",["persona"=>Persona::findOrFail($id)]);
    }

	public function edit($id)
	{
	return view("compras.proveedor.edit",["persona"=>Persona::findOrFail($id)]);
	}

	public function update(PersonaformRequest $request, $id)
	{
		$persona =Persona::findOrFail($id);
		$persona ->nombre=$request->get('nombre');
		$persona ->tipo_documento=$request->get('tipo_documento');
		$persona ->num_documento=$request->get('num_documento');
		$persona ->nombrecontacto=$request->get('nombrecontacto');
		$persona ->direccion=$request->get('direccion');
		$persona ->telefono=$request->get('telefono');
		$persona ->email=$request->get('email');
		$persona ->notas=$request->get('notas');
		$persona ->tipocuenta=$request->get('tipocuenta');
		$persona ->banco=$request->get('banco');
		$persona ->numerodecuenta=$request->get('numerodecuenta');
		$persona ->update();
		return Redirect::to('compras/proveedor');
	}

	public function destroy($id)
	{
	$persona=Persona::findOrFail($id);
	$persona->tipo_persona='Inactivo';
	$persona->update();
	return Redirect::to('compras/proveedor');
	}
}
