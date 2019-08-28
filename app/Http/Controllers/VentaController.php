<?php 

namespace sisventas\Http\Controllers;
use Illuminate\Http\Request;
use sisventas\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use sisventas\Http\Requests\VentaFormRequest;
use sisventas\Venta;
use sisventas\DetalledeVenta; 
use sisventas\articulo;
use DB;
use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection; 

class VentaController extends Controller
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
        $ventas=DB::table('venta as v')
        ->join('persona as p','v.idcliente','=','p.idpersona')
        ->join('detalledeventa as dv','v.idventa','=','dv.idventa')
        ->join('articulo as ac','dv.idarticulo','=','ac.idarticulo')
    	->select('v.idventa','v.fecha_hora','p.nombre','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.anticipo','v.total_venta')
    		->where('v.num_comprobante','LIKE','%'.$query.'%')
            ->orwhere('v.descripcion','LIKE','%'.$query.'%')
            ->orwhere('ac.codigo','LIKE','%'.$query.'%')
            ->orwhere('p.nombre','LIKE','%'.$query.'%')
    		->orderBy('v.idventa','desc')
    		->groupBy('v.idventa','v.fecha_hora','p.nombre','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado')
    		->paginate(15);
    		return view('ventas.venta.index',["ventas"=>$ventas,"searchText"=>$query]);
    	}
    }

    	public function create()
    	{
            $idventa=DB::table('venta')->max('num_comprobante')+1; //as incredible
    		$impuestos1=DB::table('iva')->where('Estado','=','A')->get(); 
            $personas=DB::table('persona')->where('tipo_persona','!=','Proveedor')->get(); //si el provedor tambien es cliente, retirara el where
            $proyecto=DB::table('proyecto')->where('idestado','=','2')->get();
            $dataproyecto=db::table('proyecto as pro')
            ->join('persona as per', 'per.idpersona', '=', 'pro.idpersona')
            ->select('per.nombre','pro.descripcion','pro.idproyecto','pro.idpersona')
            ->where('pro.idestado','=','2')
            ->orderBy('pro.idproyecto', 'desc')
            ->get();
            $articulos=DB::table('articulo as art')
            ->join('detalle_ingreso as di','art.idarticulo','=','di.idarticulo')
            ->join('categoria as cat', 'cat.idcategoria', '=', 'art.idcategoria')
            ->select(DB::raw('CONCAT(art.codigo, "| ",art.nombre,"|$ ", di.precio_venta) AS articulo'),'art.idarticulo','art.stock', 'art.idcategoria', 'art.impuesto', DB::raw('di.precio_venta as precio_promedio'),'cat.midestock') //esta consulta extrae el promdio del valor de venta del producto
            ->where('art.estado','=','Activo')
            //->where('art.stock','>','0') // solo muestra articulos con stock en positivo
            ->groupBy('articulo','art.idarticulo','art.stock')
            ->orderBy('di.idingreso', 'desc')
    		->get();
           // $tablecategoria=db::table('categoria as cat')
            //->join('articulo as art2','art2.idcategoria', '=', 'cat.idcategoria')
            //->select('cat.midestock')
           // ->get();
			return view('ventas.venta.create',["personas"=>$personas,"articulos"=>$articulos,"impuestos1"=>$impuestos1, "idventa"=>$idventa, "proyecto"=>$proyecto, "dataproyecto"=>$dataproyecto]);
       	}
            public function show($id)
        {
            $venta=DB::table('venta as v')
            ->join('persona as p','v.idcliente','=','p.idpersona')
            ->join('detalledeventa as dv','v.idventa','=','dv.idventa')
            ->select('v.idventa','v.fecha_hora','p.nombre','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.anticipo','v.estado','v.total_venta','v.condiciones')
            ->where('v.idventa','=',$id)
            ->first();    

            $detalles=DB::table('detalledeventa as dv')
            ->join('articulo as a','dv.idarticulo','=','a.idarticulo')
            ->select('a.nombre as articulo','dv.cantidad','dv.descuento','dv.precio_venta')
            ->where('dv.idventa',$id)
            ->get();
        return view('ventas.venta.show',["venta"=>$venta,"detalles"=>$detalles]);
        }

    public function edit($id)
    {
            $venta=DB::table('venta as v')
            ->join('detalledeventa as dv','v.idventa','=','dv.idventa')
            ->select('v.total_venta','v.idventa','dv.iddetalledeventa')
            ->where('v.idventa','=',$id)
            ->first();

            $detalles=DB::table('detalledeventa as dv')     
            ->join('articulo as art','art.idarticulo','=','dv.idarticulo')
            ->select(DB::raw('CONCAT(art.codigo, " ",art.nombre) AS articulo'),'dv.idarticulo','dv.cantidad','dv.descuento','dv.iddetalledeventa as id' ,'dv.precio_venta')
            ->where('dv.idventa',$id)
            ->get();

            $articulos=DB::table('articulo as art')
            ->join('detalle_ingreso as di','art.idarticulo','=','di.idarticulo')
            ->select(DB::raw('CONCAT(art.codigo, " ",art.nombre) AS articulo'),'art.idarticulo','art.stock','art.impuesto', DB::raw('avg(di.precio_venta) as precio_promedio')) //esta consulta extrae el promdio del valor de venta del producto
            ->where('art.estado','=','Activo')
            ->where('art.stock','>','0') // solo muestra articulos con stock en positivo
            ->groupBy('articulo','art.idarticulo','art.stock')
            ->get();

    return view("ventas.venta.edit", ["venta"=>$venta,"articulos"=>$articulos,"detalles"=>$detalles]);
            
    }

    public function cancelar($id)    
    {
    $venta=venta::findOrFail($id);
    $venta->Estado='C';
    $venta->update();
    return Redirect::to('venta');
   }

   public function destroy($id)
        
        {               
           $consulta = detalledeventa::find($id);
            if (is_null ($consulta))
           {
            App::abort(404);
           }
           $consulta->delete();
           if (Request::ajax())
             {
                      return Response::json(array (
                       'success' => true,
                       'msg'     => 'Producto ' . $consulta->idarticulo . ' eliminado',
                             'id'      => $consulta->id
                       ));
                }
                  else
                {
                   return back();
                }
        }

       		public function store(VentaFormRequest $request)
    	{
             //dd($request->all());
    		try{
    			DB::beginTransaction();
    			$venta=new venta();
                $mytime = Carbon::now('America/Bogota');
    			$venta->idcliente=$request->get('idcliente');
    			$venta->tipo_comprobante=$request->get('tipo_comprobante');
    			$venta->serie_comprobante=$request->get('serie_comprobante');
    			$venta->num_comprobante=$request->get('num_comprobante');
                $venta->total_venta=$request->get('total_venta');
    			$venta->fecha_hora=$mytime->toDateTimeString();
                $venta->impuesto=(float)$request->get('impuesto');//16%
                $venta->total_general=$request->get('totalgeneral');
                $venta->total_descuento=$request->get('totaldescuento');
                $venta->subtotal=$request->get('subtotal');
                $venta->valoriva=$request->get('valoriva');
                $venta->total_venta=$request->get('totalventa');
                $venta->descripcion=$request->get('descripcion');
                $venta->estado='A';
                $venta->idproyecto=$request->get('idproyecto');
                $venta->anticipo=$request->get('anticipo');
                $venta->condiciones=$request->get('condiciones');
    		    $venta->save();
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
    				$detalles=new detalledeventa();
    				$detalles->idventa=$venta->idventa;
    				$detalles->idarticulo=$idarticulo[$cont];
    				$detalles ->cantidad=$cantidad[$cont];
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
                return Redirect::to('ventas/venta');
    	      }

        public function crear_pdf($id)
     {
            $venta=DB::table('venta as v')
            ->join('persona as p','v.idcliente','=','p.idpersona')
            ->join('detalledeventa as dv','v.idventa','=','dv.idventa')
            ->select('v.idventa','v.fecha_hora','p.nombre','p.idpersona','p.nombrecontacto','p.telefono','p.direccion','p.email', 'p.tipo_documento','p.num_documento','v.serie_comprobante','v.anticipo','v.num_comprobante','v.descripcion','v.total_general','v.total_descuento','v.subtotal','v.valoriva','v.total_venta','v.estado','v.condiciones','dv.iddetalledeventa','dv.descuento')
            ->where('v.idventa','=',$id)
            ->first(); 

            $detalle=DB::table('detalledeventa as dv')
            ->join('articulo as a','dv.idarticulo','=','a.idarticulo')
            ->select('a.nombre as articulo','a.codigo','a.imagen', 'a.descripcion','dv.cantidad','dv.precio_venta','dv.totalgeneral', 'dv.descuento', 'dv.subtotal', 'dv.iva', 'dv.total')
            ->where('idventa',$id)
            ->get();

             $date = date('Y-m-d');
             $pdf=  \PDF::loadview('ventas.venta.reporte',["detalle"=>$detalle, "venta"=>$venta]) ->setPaper('letter', 'portrait');
             $pdf->output();
             $dom_pdf = $pdf->getDomPDF();
             $canvas = $dom_pdf ->get_canvas();
             $canvas->page_text(550, 87, "Pagina {PAGE_NUM} de {PAGE_COUNT}", null, 8, array(0, 0, 0));
             return $pdf->stream("Factura de Venta # {{$venta->num_comprobante}} - del -$id.pdf");
        }
    
}  