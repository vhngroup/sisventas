<?php 

namespace sisventas\Http\Controllers;

use Illuminate\Http\Request;
use sisventas\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use sisventas\Http\Requests\VentaFormRequest;
use sisventas\venta;
use sisventas\detalledeventa; 
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
    		->select('v.idventa','v.fecha_hora','p.nombre','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.anticipo','v.total_venta')
    		->where('v.num_comprobante','LIKE','%'.$query.'%')
    		->orderBy('v.idventa','desc')
    		->groupBy('v.idventa','v.fecha_hora','p.nombre','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado')
    		->paginate(15);
    		return view('ventas.venta.index',["ventas"=>$ventas,"searchText"=>$query]);
    	}
    }

    	public function create()
    	{
            $idventa=DB::table('venta')->max('idventa')+1; //as incredible
    		$impuestos1=DB::table('impuesto')->where('Estado','=','A')->get(); 
            $personas=DB::table('persona')->where('tipo_persona','!=','Proveedor')->get(); //si el provedor tambien es cliente, retirara el where
            $articulos=DB::table('articulo as art')
            ->join('detalle_ingreso as di','art.idarticulo','=','di.idarticulo')
            ->select(DB::raw('CONCAT(art.codigo, " ",art.nombre) AS articulo'),'art.idarticulo','art.stock','art.impuesto', DB::raw('avg(di.precio_venta) as precio_promedio')) //esta consulta extrae el promdio del valor de venta del producto
            ->where('art.estado','=','Activo')
            ->where('art.stock','>','0') // solo muestra articulos con stock en positivo
            ->groupBy('articulo','art.idarticulo','art.stock')
    		->get();
			return view('ventas.venta.create',["personas"=>$personas,"articulos"=>$articulos,"impuestos1"=>$impuestos1, "idventa"=>$idventa]);
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
    		try{
    			DB::beginTransaction();
    			$venta=new venta();
    			$venta->idcliente=$request->get('idcliente');
    			$venta->tipo_comprobante=$request->get('tipo_comprobante');
    			$venta->serie_comprobante=$request->get('serie_comprobante');
    			$venta->num_comprobante=$request->get('num_comprobante');
                $venta->total_venta=$request->get('total_venta');
    			$mytime = Carbon::now('America/Bogota');
    			$venta->fecha_hora=$mytime->toDateTimeString();
    			//$ingreso->impuesto='16';//$request->get('impuesto');//16%
                $venta->impuesto=(float)$request->get('impuesto');//16%
                $venta->descripccion=$request->get('descripccion');
                $venta->estado='A';
                $venta->anticipo=$request->get('anticipo');
                $venta->condiciones=$request->get('condiciones');
                //$venta->idproyecto=$request->get('idproyecto');
    		       $venta->save();
    			$idarticulo=$request->get('idarticulo');
    			$cantidad=$request->get('cantidad');
    			$descuento=$request->get('descuento');
    			$precio_venta=$request->get('precio_venta');
    			$cont=0;
                   
    			While($cont < count($idarticulo))
                {
    				$detalles=new detalledeventa();
    				$detalles->idventa=$venta->idventa;
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
                return Redirect::to('ventas/venta');
    	      }

        public function crear_pdf($id)
     {
            $venta=DB::table('venta as v')
            ->join('persona as p','v.idcliente','=','p.idpersona')
            ->join('detalledeventa as dv','v.idventa','=','dv.idventa')
            ->select('v.idventa','v.fecha_hora','p.nombre','p.idpersona','p.nombrecontacto','p.telefono','p.direccion','p.email', 'p.tipo_documento','p.num_documento','v.serie_comprobante','v.anticipo','v.num_comprobante','v.descripccion','v.estado','v.total_venta','v.condiciones','dv.iddetalledeventa')
            ->where('v.idventa','=',$id)
            ->first(); 

            $detalle=DB::table('detalledeventa as dv')
            ->join('articulo as a','dv.idarticulo','=','a.idarticulo')
            ->select('a.nombre as articulo','a.codigo','a.imagen', 'a.descripccion','dv.cantidad','dv.descuento','dv.precio_venta')
            ->where('idventa',$id)
            ->get();

             $date = date('Y-m-d');
             $pdf=  \PDF::loadview('ventas.venta.reporte',["detalle"=>$detalle, "venta"=>$venta]) ->setPaper('letter', 'portrait');
           return $pdf->stream("Factura de Venta # $id-$date-$id.pdf");
        }
    
}  