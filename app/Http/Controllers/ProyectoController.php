<?php

namespace sisventas\Http\Controllers;

use Illuminate\Http\Request;
use sisventas\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use sisventas\Http\Requests\ProyectoFormRequest;
use sisventas\Proyecto;
use sisventas\Venta; 
use sisventas\Cotizacion;
use DB;
use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection; 

class ProyectoController extends Controller
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
        $proyectos=DB::table('proyecto as pro')
         ->join('persona as p','pro.idpersona','=','p.idpersona')
         ->leftjoin('venta as v','pro.idproyecto','=','v.idproyecto')
         ->leftjoin('cotizacion as c','pro.idproyecto','=','c.idproyecto')
         ->leftjoin('estado as e','pro.idestado','=','e.idestado')
            ->select('v.idproyecto as vidproyecto','p.nombre','v.estado','v.anticipo','v.total_venta as vtotal_venta','pro.idproyecto','pro.descripcion','pro.fecha','c.total_venta AS ctotal_venta','c.idproyecto AS cidproyecto','e.estado')
            ->where('pro.descripcion','LIKE','%'.$query.'%')
            ->orwhere('p.nombre','LIKE','%'.$query.'%')
    		->orderBy('pro.idproyecto','desc')
    		->groupBy('pro.idproyecto','pro.fecha')
    		->paginate(15);
            return view('proyectos.index',["proyectos"=>$proyectos,"searchText"=>$query]);
    	}
    }

    public function create()
    {
            $idproyecto=DB::table('proyecto')->max('idproyecto')+1;
            $estado=DB::table('estado')->where('selector','=','Proyectos')->get();
            $personas=DB::table('persona')->where('tipo_persona','!=','Proveedor')->get();
            return view('proyectos.create',["personas"=>$personas, "idproyecto"=>$idproyecto,"estado"=>$estado]);
    }

   public function store(ProyectoFormRequest $request)
        {
            try{
                DB::beginTransaction();
                $mytime = Carbon::now('America/Bogota');
                $proyecto=new proyecto();
                $proyecto->fecha=$mytime->toDateTimeString();
                $proyecto->idpersona=$request->get('idpersona');
                $proyecto->descripcion=$request->get('descripcion');
                $proyecto->alerta1=$request->get('alerta1');
                $proyecto->fechaalerta1=$mytime->toDateTimeString();
                $proyecto->alerta2=$request->get('alerta2');
                $proyecto->fechaalerta2=$mytime->toDateTimeString();
                $proyecto->idestado=$request->get('estado');
                $proyecto->observaciones=$request->get('observaciones');
                $proyecto->save();
                //$venta->fecha_hora=$mytime->toDateTimeString();
                DB::commit();
                }
                catch(\Exception $e)
                {
                DB::rollback();
                }   
                return Redirect::to('/proyectos');
        }
}
