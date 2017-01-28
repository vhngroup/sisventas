
@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-8 col-md-8 col-dm-8 col-xs-12">
	<h3> Listado de ventas <a href="/ventas/venta/create"><button class="btn btn-success">Nuevo</button></a></h3>
	@include('ventas.venta.search')
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
	@foreach($ventas as $ven)
	<tr>
		<td>{{$ven->fecha_hora}}</td>
		<td>{{$ven->nombre}}</td>
		<td>{{$ven->tipo_comprobante.': '.$ven->serie_comprobante.'-'.$ven->num_comprobante}}</td>
		<td>{{$ven->impuesto}}</td>
		<td>{{$ven->total_venta}}</td>
		<td>{{$ven->estado}}</td>
		<td>
			<a href="{{URL::action('VentaController@show',$ven->idventa)}}"><button class="btn btn-primary btn-xs">Detalles</button></a>
			<a href="{{URL::action('VentaController@edit',$ven->idventa)}}"><button class="btn btn-danger btn-xs">Editar</button></a>
		    <a href="{{URL::action('VentaController@crear_pdf',$ven->idventa)}}" target=newtab "><button class="btn btn-primary btn-xs">Imprimir</button></a>
		</td>
	</tr>
	@include('ventas.venta.modal')	
	@endforeach
	</table>
	</div>
	{{$ventas->render()}}
	</div>	
</div>
@endsection