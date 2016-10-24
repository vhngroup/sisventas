<?php

namespace sisventas\Http\Controllers;

use Illuminate\Http\Request;
use sisventas\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use sisventas\Http\Requests\IngresoformRequest;
use sisventas\ingreso;
use sisventas\Detalledeingreso;

use DB;
use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;

class IngresoController extends Controller
{
   public function __construct()
    {

    }

    public function index(Request $request)
    {
    	if($request)
    	{
    		$query=trim($request->GET('searchText'));

        $ingreso=DB::table('ingreso as i')
         ->join('persona as p','i.idproveedor','=','p.idpersona')
        ->join('detalle_ingreso as di','i.idingreso','=','di.idingreso')
    		->select('i.idingreso','i.fecha_hora','p.nombre','i.tipo_comprobante','i.serie_comprobante','i.numero_comprobante','i.impuesto','i.estado',DB::raw('sum(di.cantidad*precio_compra) as total'))
    		->where('i.numero_comprobante','LIKE','%'.$query.'%')
    		->orderBy('i.idingreso','desc')
    		->groupBy('i.idingreso','i.fecha_hora','p.nombre','i.tipo_comprobante','i.serie_comprobante','i.numero_comprobante','i.impuesto','i.estado')
    		->paginate(7);
    		return view('compras.ingreso.index',["ingreso"=>$ingreso,"searchText"=>$query]);
    	}
    }

    	public function create()
    	{
    		$impuestos=DB::table('impuesto')->where('Estado','=','A')->get();
            $personas=DB::table('persona')->where('tipo_persona','=','proveedor')->get();
    		$articulos=DB::table('articulo as art')
            ->select(DB::raw('CONCAT(art.codigo, " ",art.nombre) AS articulo'),'art.idarticulo')
            ->where('art.estado','=','Activo')
    		->get();
			return view('compras.ingreso.create',["personas"=>$personas,"articulos"=>$articulos,"impuestos"=>$impuestos]);
       	}

       		public function store(IngresoFormRequest $request)
    	{
    		try{
    			DB::beginTransaction();
    			$ingreso=new ingreso();
    			$ingreso->idproveedor=$request->get('idproveedor');
    			$ingreso->tipo_comprobante=$request->get('tipo_comprobante');
    			$ingreso->serie_comprobante=$request->get('serie_comprobante');
    			$ingreso->numero_comprobante=$request->get('numero_comprobante');
    			$mytime = Carbon::now('America/Bogota');
    			$ingreso->fecha_hora=$mytime->toDateTimeString();
    			//$ingreso->impuesto='16';//$request->get('impuesto');//16%
                $ingreso->impuesto=(float)$request->get('impuesto');//16%
                $ingreso->estado='A';
                $ingreso->anticipo=$request->get('anticipo');
    			$ingreso->save();

    			$idarticulo=$request->get('idarticulo');
    			$cantidad=$request->get('cantidad');
    			$precio_compra=$request->get('precio_compra');
    			$precio_venta=$request->get('precio_venta');

    			$cont=0;
    			While($cont < count($idarticulo)){
    				$detalles=new DetalledeIngreso();
    				$detalles->idingreso=$ingreso->idingreso;
    				$detalles->idarticulo=$idarticulo[$cont];
    				$detalles ->cantidad=$cantidad[$cont];
    				$detalles ->precio_compra=$precio_compra[$cont];
    				$detalles->precio_venta=$precio_venta[$cont];
    				$detalles->save();
    				$cont=$cont+1;
    			}
    			DB::commit();
    		}
    catch(\Exception $e)
    {

			DB::rollback();
   		}
          return Redirect::to('compras/ingreso');
    	}

    	public function show($id)
    	{
    		$ingreso=DB::table('ingreso as i')
    		->join('persona as p','i.idproveedor','=','p.idpersona')
    		->join('detalle_ingreso as di','i.idingreso','=','di.idingreso')
    		->select('i.idingreso','i.fecha_hora','p.nombre','i.tipo_comprobante','i.serie_comprobante','i.numero_comprobante','i.impuesto','i.estado',DB::raw('sum(di.cantidad*precio_compra) as total'))
    		->where('i.idingreso','=',$id)
    		->firts();

    		$detalles=DB::table('detalle_ingreso as d')
    		->join('articulo as a','d.idarticulo','=','a.idarticulo')
    		->select('a.nombre as articulo','d,cantidad','d.precio_compra','d.precio_venta')
			->where('d.idingreso',$id)
			->get();
		return view('compras.ingreso.show',["ingreso"=>$ingreso,"detalles"=>$detalles]);
    	}

    	public function destroy($id)
    	{
    		$ingreso=Ingreso::findOrFail($id);
			$ingreso->Estado='C';
			$ingreso>update();
			return Redirect::to('compras/ingreso');
    	}
}
