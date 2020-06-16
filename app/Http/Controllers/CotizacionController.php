<?php

namespace sisventas\Http\Controllers;
use Illuminate\Http\Request;
use sisventas\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use sisventas\Http\Requests\CotizacionFormRequest;
use sisventas\Cotizacion;
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
         ->join('articulo as ac', 'dc.idarticulo','=','ac.idarticulo')
    	 ->select('c.idcotizacion','c.fecha_hora','p.nombre','c.serie_comprobante','c.num_comprobante','c.descripcion','c.estado','c.total_venta','c.condiciones')
    		->where('c.num_comprobante','LIKE','%'.$query.'%')
    		->orwhere('c.descripcion','LIKE','%'.$query.'%')
            ->orwhere('ac.codigo','LIKE','%'.$query.'%')
            ->orwhere('p.nombre','LIKE','%'.$query.'%')
            ->orderBy('c.idcotizacion','desc')
    		->groupBy('c.idcotizacion','c.fecha_hora','p.nombre','c.serie_comprobante','c.num_comprobante','c.estado')
    		->paginate(15);
    		return view('cotizaciones.index',["cotizacion"=>$cotizacion,"searchText"=>$query]);
    	}
    }

    	public function create()
    	{
            $icotizacion=DB::table('cotizacion')->max('idcotizacion')+1; //as incredible
            $impuestos=DB::table('iva')->where('Estado','=','A')->get(); 
            $personas=DB::table('persona as per')->where('tipo_persona','!=','Proveedor')->get(); //si el provedor tambien es cliente, retirara el where
            $proyecto=DB::table('proyecto')->where('idestado','=','2')->get();
            $dataproyecto=db::table('proyecto as pro')
            ->join('persona as per', 'per.idpersona', '=', 'pro.idpersona')
            ->select('per.nombre','pro.descripcion','pro.idproyecto','pro.idpersona')
            ->where('pro.idestado','=','2')
            ->orderBy('pro.idproyecto', 'desc')
            ->get();
            $articulos=DB::table('articulo as art')
            ->join('detalle_ingreso as di','art.idarticulo','=','di.idarticulo')
            //->join('ingreso as ing','ing.idingreso','=','di.idingreso') 
            ->select(DB::raw('CONCAT(art.codigo, "| ",art.nombre, "|$ ", di.precio_venta ) AS articulo'),'art.idarticulo','art.stock','art.impuesto', DB::raw('di.precio_venta as precio_promedio'))
            ->where('art.estado','=','Activo')
            ->groupBy('articulo','art.idarticulo','art.stock')    
            ->orderBy('di.idingreso', 'desc')
    		->get();

			return view('cotizaciones.create',["personas"=>$personas,"articulos"=>$articulos,"impuestos"=>$impuestos,"icotizacion"=>$icotizacion,"proyecto"=>$proyecto, "dataproyecto"=>$dataproyecto]);
       	}

    public function store(CotizacionFormRequest $request)
    	{
    		           
            //  dd($request->all());
            try{
    			 DB::beginTransaction();
                
    			$cotizacion=new cotizacion();
                $mytime = Carbon::now('America/Bogota');
                $cotizacion->fecha_hora=$mytime->toDateTimeString();
    			$cotizacion->idcliente=$request->get('idcliente');
    			$cotizacion->serie_comprobante=$request->get('serie_comprobante');
    			$cotizacion->num_comprobante=$request->get('num_comprobante');
                $cotizacion->descripcion=$request->get('descripcion');
                $cotizacion->impuesto=(float)$request->get('impuesto');//19%
                $cotizacion->total_general=$request->get('totalgeneral');
                $cotizacion->total_descuento=$request->get('totaldescuento');
                $cotizacion->subtotal=$request->get('subtotal');
                $cotizacion->valoriva=$request->get('valoriva');
                $cotizacion->total_venta=$request->get('totalventa');
                $cotizacion->estado='A';
                $cotizacion->idproyecto=$request->get('idproyecto');
                $cotizacion->condiciones=$request->get('condiciones');
    		    $cotizacion->save();
                $idarticulo=$request->get('idarticulo');
                $cantidad=$request->get('cantidad');
                $descuento=$request->get('descuento');
                $precio_venta=$request->get('precio_venta');
                $acm_Totalgeneral=$request->get('acm_Totalgeneral');
                $acm_Descuento=$request->get('acm_Descuento');
                $acm_Subtotal=$request->get('acm_Subtotal');
                $acm_Iva=$request->get('acm_Iva');
                $acm_Total=$request->get('acm_Total');
    			$cont=0;
    			While($cont < count($idarticulo))
                {
    				$detalles=new detalledecotizacion();
    				$detalles->idcotizacion=$cotizacion->idcotizacion;
    				$detalles->idarticulo=$idarticulo[$cont];
    				$detalles->cantidad=$cantidad[$cont];
    				$detalles->precio_venta=$precio_venta[$cont];
                    $detalles->totalgeneral=$acm_Totalgeneral[$cont];
                    $detalles->descuento=$acm_Descuento[$cont];
                    $detalles->subtotal=$acm_Subtotal[$cont];
                    $detalles->iva=$acm_Iva[$cont];
                    $detalles->total=$acm_Total[$cont];
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
    		->select('c.idcotizacion','c.fecha_hora','c.fecha_hora','p.nombre','c.serie_comprobante','c.num_comprobante','c.descripcion','c.condiciones','c.estado','c.idproyecto','c.total_venta')
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
            ->select('c.idcotizacion','c.fecha_hora','p.nombre','p.tipo_documento','p.nombrecontacto','p.num_documento','p.telefono','p.email','p.direccion','c.serie_comprobante','c.num_comprobante','c.descripcion','c.total_general','c.total_descuento','c.subtotal','c.valoriva','c.total_venta','c.estado','c.total_venta','c.condiciones','dc.descuento')
            ->where('c.idcotizacion','=', $id)
            ->first(); 

            $detalle=DB::table('detallecotizacion as dc')
            ->join('articulo as a','dc.idarticulo','=','a.idarticulo')
            ->select('a.nombre as articulo','a.codigo','a.imagen', 'a.descripcion','dc.cantidad', 'dc.precio_venta','dc.totalgeneral', 'dc.descuento', 'dc.subtotal', 'dc.iva', 'dc.total')

            ->where('idcotizacion','=', $id)
            ->get();

             $date = date('Y-m-d');
             $pdf=  \PDF::loadview('cotizaciones.reporte',["detalle"=>$detalle, "cotizacion"=>$cotizacion]) ->setPaper('letter', 'portrait');
             //->set_option('isHtml5ParserEnabled', TRUE);
           $pdf->output();
             $dom_pdf = $pdf->getDomPDF();
             $canvas = $dom_pdf ->get_canvas();
             $canvas->page_text(550, 87, "Pagina {PAGE_NUM} de {PAGE_COUNT}", null, 8, array(0, 0, 0));
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
