
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
		<th>Comprobante</th>
		<th>Impuesto</th>
		<th>Total</th>
		<th>Estado</th>
		<th>Opcciones</th>
	</thead>
	@foreach($cotizacion as $ven)
	<tr>
		<td>{{$ven->fecha_hora}}</td>
		<td>{{$ven->nombre}}</td>
		<td>{{$ven->serie_comprobante.'-'.$ven->num_comprobante}}</td>
		<td>{{$ven->impuesto}}</td>
		<td>{{$ven->total_venta}}</td>
		<td>{{$ven->estado}}</td>
		<td>
			<a href="{{URL::action('CotizacionController@show',$ven->idcotizacion)}}"><button class="btn btn-primary">Detalles</button></a>
			<a href="" data-target="#modal-delete-{{$ven->idcotizacion}}" data-toggle="modal"><button class="btn btn-danger">Anular</button></a>
		   	<a href="{{URL::action('CotizacionController@reporte',$ven->idcotizacion)}}"><button class="btn btn-primary">Imprimir</button></a>
		</td>
	</tr>
	@include('cotizaciones.modal')		
	@endforeach
	</table>
	</div>
	{{$cotizacion->render()}}
	</div>	
</div>
@endsection