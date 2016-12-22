@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-8 col-md-8 col-dm-8 col-xs-12">
	<h3> Listado de cotizaciones <a href="cotizaciones/create"><button class="btn btn-success">Nuevo</button></a></h3>
	@include('cotizaciones.search')
	</div>
</div>
<div class="row">
	<div class="col-lg-12 col-md-12 col-dm-12 col-xs-12">
	<div class="table-responsive">
	<table class="table table-striped table-bordered table-condensed table-hover">
	<thead>
		<th>Fecha</th>
		<th>Cliente</th>
		<th>Alcance</th>
		<th>Comprobante</th>
		<th>Total</th>
		<th>Opcciones</th>
	</thead>
	@foreach($cotizacion as $ven)
	<tr>
		<td>{{$ven->fecha_hora}}</td>
		<td>{{$ven->nombre}}</td>
		<td>{{$ven->descripccion}}</td>
		<td>{{$ven->serie_comprobante.'-'.$ven->num_comprobante.'-'.$ven->estado}}</td>
		<td>{{$ven->total_venta}}</td>
		<td>
			<a href="{{URL::action('CotizacionController@show',$ven->idcotizacion)}}"><button class="btn btn-primary btn-xs">Detalles</button></a>
			<a href="" data-target="#modal-delete-{{$ven->idcotizacion}}" data-toggle="modal"><button class="btn btn-danger btn-xs">Anular</button></a>
		   	<a href="{{URL::action('CotizacionController@crear_pdf',$ven->idcotizacion)}}" target=newtab "><button class="btn btn-primary btn-xs">Imprimir</button></a>
		</td>
	</tr>
	@include('cotizaciones.modal')		
	@endforeach
	</table>
	</div>
	{{$cotizacion->render()}}
	</div>	
</div>
 {!!Form::close()!!}  
@endsection