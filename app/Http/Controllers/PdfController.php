<?php

namespace sisventas\Http\Controllers;

use Illuminate\Http\Request;
use sisventas\Http\Requests;
use sisventas\Http\Controllers\Controller;
use sisventas\Venta;
use sisventas\Persona;
use DB;

class PdfController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("pdf.index");
    } 


      public function crearPDF($datos,$vistaurl,$tipo)
    {
        $data = $datos;
        $ventas=DB::table('venta as v')
         ->join('persona as p','v.idcliente','=','p.idpersona');

        $date = date('Y-m-d');
        $view =  \View::make($vistaurl, compact('data', 'date', 'ventas'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        if($tipo==1){return $pdf->stream('reporte',["ventas"=>$ventas]);}
        if($tipo==2){return $pdf->download('reporte.pdf'); }
    }

    public function crear_reporte_porventa($tipo){
     //$persona->idventa=$venta->idventa;
     $vistaurl="pdf.reporte_por_venta";
     $venta=venta::all();
     return $this->crearPDF($venta, $vistaurl,$tipo);
//venta = datos;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
