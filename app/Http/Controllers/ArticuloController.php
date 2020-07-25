<?php
namespace sisventas\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use sisventas\Http\Requests\ArticuloFormRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use sisventas\Articulo;
use sisventas\Http\Requests\IngresoFormRequest;
use sisventas\ingreso;
use sisventas\DetalledeIngreso; 
use Carbon\Carbon;
use DB;

class ArticuloController extends Controller
{ 
   public function __construct()
    {
	$this->middleware('auth');
    }

    public function index(Request $request)
    {
    	if($request)
    	{
    		$query=trim($request->get('searchText'));
    		$articulos=DB::table('articulo as a')
    		->join ('categoria as c','a.idcategoria','=','c.idcategoria')
    		->leftjoin('detalle_ingreso as dt', 'a.idarticulo', '=', 'dt.idarticulo')
			->select('a.idarticulo','a.nombre', 'a.codigo', 'a.stock', 'c.nombre as categoria','a.descripcion', 'a.imagen', 'a.estado', 'a.impuesto', 'dt.precio_compra', 'dt.precio_venta','dt.iddetalle_ingreso')
    		->where('a.codigo','LIKE','%'.$query.'%')
            ->orwhere('a.nombre','LIKE','%'.$query.'%')
    		->orderBy('a.idarticulo','desc')->take(1)
    		->paginate(10);
    		return view('almacen.articulo.index',["articulos"=>$articulos,"searchText"=>$query]);
    	}

    }
    public function create()
    {
    	$personas=DB::table('persona')->where('tipo_persona','!=','Cliente')->get();
    	$impuestos=DB::table('iva')->where('Estado','=','A')->get();
    	$iingreso=DB::table('ingreso')->max('idingreso')+1;
    	$idarticulo=DB::table('articulo')->max('idarticulo')+1;
    	$reteica=DB::table('ica')->where('Estado','=','A')->get();
    	$retefuente=DB::table('retefuente')->where('Estado','=','A')->get();
		$categorias=DB::table('categoria')->where('condicion','=','1')->get();
		return view("almacen.articulo.create",["categorias"=>$categorias, "personas"=>$personas, "iingreso"=>$iingreso, "impuestos"=>$impuestos, "reteica"=>$reteica, "retefuente"=>$retefuente, "idarticulo"=>$idarticulo]);
    }

    public function store (ArticuloFormRequest $request)
    {
        try{
             DB::beginTransaction();
		$articulo=new articulo;
		$articulo->idcategoria=$request->get('idcategoria');
		$articulo->codigo=$request->get('codigo');
		$articulo->nombre=$request->get('nombre');
		$articulo->stock=$request->get('stock');
		$articulo->impuesto=(float)$request->get('impuesto');
		$articulo->descripcion=$request->get('descripcion');
		$articulo->estado='Activo';

		if($request->hasFile('imagen'))
			{
				$file=$request->file('imagen');
				$file->move(public_path().'/imagenes/articulos/',$file->getClientOriginalName());
				$articulo->imagen=$file->getClientOriginalName();
			}
				$articulo->save();

		$ingreso=new ingreso();
        $ingreso->idproveedor=$request->get('idproveedor');
        $ingreso->tipo_comprobante=$request->get('tipo_comprobante');
        $ingreso->serie_comprobante=$request->get('serie_comprobante');
        $ingreso->numero_comprobante=$request->get('numero_comprobante');
        $mytime = Carbon::now('America/Bogota');
        $ingreso->fecha_hora=$mytime->toDateTimeString();
        
        $ingreso->impuesto=(float)$request->get('impuesto');
        $ingreso->estado='A';
        $ingreso->anticipo=0;
        $ingreso->save();

		$idarticulo=$request->get('idarticulo');
        $cantidad=$request->get('cantidad');
        $precio_compra=$request->get('precio_compra');
        $precio_venta=$request->get('precio_venta');

        $detalles=new DetalledeIngreso();
        $detalles->idingreso=$ingreso->idingreso;
        $detalles->idarticulo=$articulo->idarticulo;
        $detalles->cantidad=0;
        $detalles->precio_compra=$request->get('precio_compra');
        $detalles->precio_venta=$request->get('precio_venta');
        $detalles->save();

				DB::commit();
         }
    	catch(\Exception $e)
    	 {
         DB::rollback();
        }

        return Redirect::to('almacen/articulo');
       }

  public function update(ArticuloFormRequest $request, $id)
	{
		$articulo =Articulo::findOrFail($id);
		$articulo->idcategoria=$request->get('idcategoria');
		$articulo->nombre=$request->get('nombre');
		$articulo->codigo=$request->get('codigo');
		$articulo->impuesto=(float)$request->get('impuesto'); 
		$articulo->stock=$request->get('stock');
		$articulo->descripcion=$request->get('descripcion');

		if($request->hasFile('imagen'))
		{
		$file=$request->file('imagen');
		$file->move(public_path().'/imagenes/articulos/',$file->getClientOriginalName());
		
		$articulo->imagen=$file->getClientOriginalName();
		}
		$articulo->update();
		return Redirect::to('almacen/articulo');
}

    public function show($id)
    {
		return view("almacen.articulo.show",["articulo"=>Articulo::findOrFail($id)]);
    }

	public function edit($id)
	{
	$articulo = Articulo::findOrFail($id);
	$impuestos=DB::table('iva')->where('Estado','=','A')->get();
	$categorias=DB::table('categoria')->where('condicion','=','1')->get();
	return view("almacen.articulo.edit",["articulo"=>$articulo,"categoria"=>$categorias,"impuestos"=>$impuestos]);
	}

	public function destroy($id)
	{
	$articulo=Articulo::findOrFail($id);
	$articulo->estado='Inactivo';
	$articulo->update();
	return Redirect::to('almacen/articulo');
	}
}
