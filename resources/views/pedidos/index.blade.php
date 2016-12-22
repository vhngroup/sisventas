@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-8 col-md-8 col-dm-8 col-xs-12">
	<h3> Listado de pedidos <a href="pedidos/create"><button class="btn btn-success">Nuevo</button></a></h3>
	@include('pedidos.search')
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
		<th>Total</th>
		<th>Estado</th>
		<th>Opcciones</th>
	</thead>
	@foreach($pedido as $ped)
	<tr>
		<td>{{$ped->fecha_hora}}</td>
		<td>{{$ped->nombre}}</td>
		<td>{{$ped->num_comprobante}}</td>
		<td>{{$ped->total_venta}}</td>
		<td>
			<a href="{{URL::action('PedidoController@show',$ped->idpedido)}}"><button class="btn btn-primary">Detalles</button></a>
			<a href="" data-target="#modal-delete-{{$ped->idpedido}}" data-toggle="modal"><button class="btn btn-danger">Anular</button></a>
		   	<a href="{{URL::action('PedidoController@crear_pdf',$ped->idpedido)}}" target=newtab "><button class="btn btn-primary">Imprimir</button></a>
		</td>
	</tr>
	@include('pedidos.modal')		
	@endforeach
	</table>
	</div>
	{{$pedido->render()}}
	</div>	
</div>
 {!!Form::close()!!}  
@endsection