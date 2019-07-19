@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-8 col-md-8 col-dm-8 col-xs-12">
	<h3> 
		Listado de Proyectos <a href="proyectos/create"><button class="btn btn-primary">Nuevo</button></a> 
		<a href="cotizaciones/create"><button class="btn btn-secondary">Cotizaciones</button></a>
		<a href="ventas/venta/create"><button class="btn btn-secondary">Ventas</button></a>
	</h3>
	@include('proyectos.search')
	</div>
</div>
<div class="row">
	<div class="col-lg-12 col-md-12 col-dm-12 col-xs-12">
	<div class="table-responsive">
	<table class="table table-striped table-bordered table-condensed table-hover">
	<thead>
		<th>Id</th>
		<th>Fecha</th>
		<th>Cliente</th>
		<th>Descripcion</th>
		<th>Estado</th>
		<th>Valor</th>
		<th>Opcciones</th>
	</thead>
	@foreach($proyectos as $pro)
	<tr>
		<td>{{$pro->idproyecto}}</td>
		<td class="col-sm-1">{{$pro->fecha}}</td>
		<td class="col-sm-2">{{$pro->nombre}}</td>
		<td class="col-sm-3">{{$pro->descripcion}}</td>
		<td class="col-sm-2">{{$pro->estado}}</td>
		@if($pro->estado=="Evaluación")
				@if($pro->idproyecto==$pro->vidproyecto)
						<td>$ <?php echo number_format($pro->vtotal_venta,1,".",",");?></td>
				@else	
						<td>$ <?php echo number_format(0,1,".",",");?></td>
				@endif
		@else
				@if($pro->idproyecto==$pro->cidproyecto)
					<td>$ <?php echo number_format($pro->ctotal_venta,1,".",",");?></td>
				@else	
					<td>$ <?php echo number_format(0,1,".",",");?></td>
				@endif
		@endif
		<td>
			<a href="{{URL::action('ProyectoController@show',$pro->idproyecto)}}"><button class="btn btn-primary btn-xs">Detalles</button></a>
			<a href="{{URL::action('ProyectoController@edit',$pro->idproyecto)}}"><button class="btn btn-danger btn-xs">Editar</button></a>
		    <a href="#" target=newtab "><button class="btn btn-primary btn-xs">Imprimir</button></a>
		</td>
	</tr>
	@include('proyectos.modal')	
	@endforeach
	</table>
	</div>
	{{$proyectos->render()}}
	</div>	
</div>
@endsection
