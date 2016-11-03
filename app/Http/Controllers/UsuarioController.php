<?php

namespace sisventas\Http\Controllers;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
//use sisventas\Http\Requests;
use Illuminate\Http\Request;
use sisventas\Http\Requests;

use Illuminate\Support\Facades\Redirect;
use sisventas\Http\Requests\UsuarioFormRequest;
use sisventas\User;
use DB;

class UsuarioController extends Controller
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
    		$usuarios=DB::table('users')->where('name','LIKE','%'.$query.'%')
    		->orderBy('id','desc')
    		->paginate(7);
    		return view('seguridad.usuario.index',["usuarios"=>$usuarios,"searchText"=>$query]);
    	}
    }

    public function create()
    	{

    		return view("seguridad.usuario.create");
    	}

public function store (UsuarioFormRequest $request)
    {
        $usuario = new user;
        $v = \Validator::make($request->all(), [
             'email' => 'required|email|unique:users',
            ]);
 
        if ($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v->errors());
        }
        else
        {
        $usuario ->name=$request->get('name');
    	$usuario ->email=$request->get('email');
    	$usuario ->password=bcrypt ($request->get('password'));
    	$usuario ->save();
    	return Redirect::to('seguridad/usuario');
    }
    }

    public function edit($id)
    {
    	return view("seguridad.usuario.edit",["usuario"=>User::findOrFail($id)]);
    }

	public function update(UsuarioFormRequest $request, $id)
    {
        $v = \Validator::make($request->all(), [
            'email'    => 'required|email',
            ]);
        $usuario = user::findOrFail($id);
    	$usuario ->name=$request->get('name');
    	$usuario ->email=$request->get('email');
    	$usuario ->password=bcrypt ($request->get('password'));
    	$usuario ->update();
    	return Redirect::to('seguridad/usuario');
    }

    public function destroy($id)
    {
    	$usuario=DB::table('users')->where('id','=',$id)->delete();
    	return Redirect::to('seguridad/usuario');
    }
}
