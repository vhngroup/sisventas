<?php

namespace sisventas\Http\Controllers;
use Illuminate\Http\Request;
use sisventas\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use sisventas\Http\Requests\CotizacionFormRequest;
use sisventas\cotizacion;
use sisventas\detalledecotizacion; 
use DB;
use Carbon\Carbon;
use Response;
use PDF;

class CotizacionController extends Controller
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

        $cotizacion=DB::table('cotizacion as c')
         ->join('persona as p','c.idcliente','=','p.idpersona')
        ->join('detallecotizacion as dc','c.idcotizacion','=','dc.idcotizacion')
    		->select('c.idcotizacion','c.fecha_hora','p.nombre','c.serie_comprobante','c.num_comprobante','c.descripccion','c.estado','c.total_venta','c.condiciones')
    		->where('c.num_comprobante','LIKE','%'.$query.'%')
    		->orderBy('c.idcotizacion','desc')
    		->groupBy('c.idcotizacion','c.fecha_hora','p.nombre','c.serie_comprobante','c.num_comprobante','c.estado')
    		->paginate(10);
    		return view('cotizaciones.index',["cotizacion"=>$cotizacion,"searchText"=>$query]);
    	}
    }

    	public function create()
    	{
            $icotizacion=DB::table('cotizacion')->max('idcotizacion')+1; //as incredible
            $impuestos=DB::table('impuesto')->where('Estado','=','A')->get(); 
            $personas=DB::table('persona')->where('tipo_persona','!=','Proveedor')->get(); //si el provedor tambien es cliente, retirara el where
            $articulos=DB::table('articulo as art')
            ->join('detalle_ingreso as di','art.idarticulo','=','di.idarticulo')
            ->select(DB::raw('CONCAT(art.codigo, " ",art.nombre) AS articulo'),'art.idarticulo','art.stock','art.impuesto', DB::raw('avg(di.precio_venta) as precio_promedio')) //esta consulta extrae el promdio del valor de cotizacion del producto
            ->where('art.estado','=','Activo')
            ->groupBy('articulo','art.idarticulo','art.stock')
    		->get();
			return view('cotizaciones.create',["personas"=>$personas,"articulos"=>$articulos,"impuestos"=>$impuestos, "icotizacion"=>$icotizacion]);
       	}

       		public function store(cotizacionFormRequest $request)
    	{
    		try{
    			DB::beginTransaction();
    			$cotizacion=new cotizacion();
    			$cotizacion->idcliente=$request->get('idcliente');
    			$cotizacion->serie_comprobante=$request->get('serie_comprobante');
    			$cotizacion->num_comprobante=$request->get('num_comprobante');
                $cotizacion->total_venta=$request->get('total_venta');
                $cotizacion->descripccion=$request->get('descripccion');
    			$mytime = Carbon::now('America/Bogota');
    			$cotizacion->fecha_hora=$mytime->toDateTimeString();
    			//$ingreso->impuesto='16';//$request->get('impuesto');//16%
                $cotizacion->impuesto=(float)$request->get('impuesto');//16%
                $cotizacion->estado='A';
                $cotizacion->condiciones=$request->get('condiciones');
                //$cotizacion->anticipo=$request->get('anticipo');
                //$cotizacion->idproyecto=$request->get('idproyecto');
    		   $cotizacion->save();
    			$idarticulo=$request->get('idarticulo');
    			$cantidad=$request->get('cantidad');
    			$descuento=$request->get('descuento');
    			$precio_venta=$request->get('precio_venta');
    			$cont=0;
                   
    			While($cont < count($idarticulo))
                {
    				$detalles=new detalledecotizacion();
    				$detalles->idcotizacion=$cotizacion->idcotizacion;
    				$detalles->idarticulo=$idarticulo[$cont];
    				$detalles ->cantidad=$cantidad[$cont];
    				$detalles ->descuento=$descuento[$cont];
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
                return Redirect::to('cotizaciones');
    }

    	public function show($id)
    	{
    		$cotizacion=DB::table('cotizacion as c')
    		->join('persona as p','c.idcliente','=','p.idpersona')
    		->join('detallecotizacion as dc','c.idcotizacion','=','dc.idcotizacion')
    		->select('c.idcotizacion','c.fecha_hora','c.fecha_hora','p.nombre','c.serie_comprobante','c.num_comprobante','c.descripccion','c.condiciones','c.estado','c.total_venta')
    		->where('c.idcotizacion','=',$id)
            ->first();    

    		$detalles=DB::table('detallecotizacion as dc')
    		->join('articulo as a','dc.idarticulo','=','a.idarticulo')
    		->select('a.nombre as articulo','dc.cantidad','dc.descuento','dc.precio_venta')
			->where('dc.idcotizacion',$id)
			->get();

		return view('cotizaciones.show',["cotizacion"=>$cotizacion,"detalles"=>$detalles]);
    	}

    public function crear_pdf($id) 
     {
            $cotizacion=DB::table('cotizacion as c')
            ->join('persona as p','c.idcliente','=','p.idpersona')
            ->join('detallecotizacion as dc','c.idcotizacion','=','dc.idcotizacion')
            ->select('c.idcotizacion','c.fecha_hora','p.nombre','p.tipo_documento','p.nombrecontacto','p.num_documento','p.telefono','p.email','p.direccion','c.serie_comprobante','c.num_comprobante','c.descripccion','c.estado','c.total_venta','c.condiciones')
            ->where('c.idcotizacion','=', $id)
            ->first(); 

            $detalle=DB::table('detallecotizacion as dc')
            ->join('articulo as a','dc.idarticulo','=','a.idarticulo')
            ->select('a.nombre as articulo','a.codigo','a.imagen', 'a.descripccion','dc.cantidad','dc.precio_venta')

            ->where('idcotizacion','=', $id)
            ->get();

             $date = date('Y-m-d');
             $pdf=  \PDF::loadview('cotizaciones.reporte',["detalle"=>$detalle, "cotizacion"=>$cotizacion]) ->setPaper('letter', 'portrait');
           return $pdf->stream("cotizacion # $id-$date-$id.pdf");
    }
	   	public function destroy($id)
    	{
    		$cotizacion=cotizacion::findOrFail($id);
			$cotizacion->Estado='C';
			$cotizacion->update();
			return Redirect::to('cotizaciones');
    	}

}
