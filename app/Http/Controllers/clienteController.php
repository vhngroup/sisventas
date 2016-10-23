<?php

namespace sisventas\Http\Controllers;

use Illuminate\Http\Request;
use sisventas\Http\Requests;
use sisventas\Persona;
use Illuminate\Support\Facades\Redirect;
use sisventas\Http\Requests\PersonaformRequest;
use DB;

class clienteController extends Controller
{
    public function __construct()
    {

    }

    public function index(Request $request)
    {
    	if($request)
    	{
    		$query=trim($request->GET('searchText'));
    		$personas=DB::table('persona')
    		->where('nombre','LIKE','%'.$query.'%')
    		->where('tipo_persona','=','Cliente')
    		->orwhere('num_documento','LIKE','%'.$query.'%')
    		->where('tipo_persona','=','Cliente')
    		->orwhere('telefono','LIKE','%'.$query.'%')
    		->where('tipo_persona','=','Cliente')
    		->orderBy('idPersona','desc')
    		->paginate(7);
    		return view('ventas.cliente.index',["personas"=>$personas,"searchText"=>$query]);
    	}

    }
    public function create()
    {
		return view("ventas.cliente.create");
    }

    public function store (PersonaformRequest $request)
    {
		$persona =new Persona;
		$persona ->tipo_persona='Cliente';
		$persona ->nombre=$request->get('nombre');
		$persona ->tipo_documento=$request->get('tipo_documento');
		$persona ->num_documento=$request->get('num_documento');
		$persona ->direccion=$request->get('direccion');
		$persona ->telefono=$request->get('telefono');
		$persona ->email=$request->get('email');
		$persona ->cuenta='No';
		$persona ->save();
		return Redirect::to('ventas/cliente');
    }

    public function show($id)
    {
		return view("ventas.cliente.show",["persona"=>Persona::findOrFail($id)]);
    }

	public function edit($id)
	{
	return view("ventas.cliente.edit",["persona"=>Persona::findOrFail($id)]);
	}

	public function update(PersonaformRequest $request, $id)
	{
		$persona =Persona::findOrFail($id);
		$persona ->nombre=$request->get('nombre');
		$persona ->tipo_documento=$request->get('tipo_documento');
		$persona ->num_documento=$request->get('num_documento');
		$persona ->direccion=$request->get('direccion');
		$persona ->telefono=$request->get('telefono');
		$persona ->email=$request->get('email');
		$persona ->update();
		return Redirect::to('ventas/cliente');
	}

	public function destroy($id)
	{
	$persona=Persona::findOrFail($id);
	$persona->tipo_persona='Inactivo';
	$persona->update();
	return Redirect::to('ventas/cliente');
	}
}
