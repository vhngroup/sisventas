@extends('layouts.admin')
@section('contenido')
<div class="row">	
	<div class="col-lg-12 col-md-6 col-dm-12 col-xs-12">
		<div class="form-group">
			  <label for="nombre">Cliente</label>
            <p>{{$venta->nombre}}</p>
			</select>
		</div>
	</div>

	<div class="col-lg-3 col-md-4 col-dm-12 col-xs-12">
		<div class="form-group">
			<label>Tipo de Comprobante</label>
			<p>{{$venta->tipo_comprobante}}</p>
		</div>
	</div>

	<div class="col-lg-3 col-md-4 col-dm-12 col-xs-12">
		<div class="form-group">
				<label for="serie_comprobante">Serie Comprobante</label>
				<p>{{$venta->serie_comprobante}}</p>
		</div>
	</div>

	<div class="col-lg-3 col-md-4 col-dm-12 col-xs-12">
		<div class="form-group">
				<label for="numero_comprobante">Numero de Comprobante</label>
				<p>{{$venta->num_comprobante}}</p>
		</div>
	</div>	

	<div class="col-lg-3 col-md-4 col-dm-12 col-xs-12">
		<div class="form-group">
				<label for="anticipo">Anticipo</label>
				<p>{{$venta->anticipo}}</p>
		</div>
	</div>
</div>	

<div class="row">
<div class="panel panel-primary">
<div class="panel-body">
	
	<div class="col-lg-12 col-md-12 col-dm-12 col-xs-12">
		  <div class="table-responsive">
			<table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
				<thead style="background-color:#caf5a9">
					<th>Articulo</th>
					<th>Cantidad</th>
					<th>Precio Venta</th>
					<th>descuento</th>
					<th>Subtotal</th>
				</thead>
			<tfoot>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
					<th><h4 id="total">{{$venta->total_venta}}</h4></th>
			</tfoot>
		<tbody>
			@foreach($detalles as $det)
			<tr>
				<td>{{$det->articulo}}</td>
				<td>{{$det->cantidad}}</td>
				<td>{{$det->precio_venta}}</td>
				<td>{{$det->descuento}}</td>
				<td>{{($det->cantidad*$det->precio_venta)-$det->descuento}}</td>
			</tr>
			@endforeach
		</tbody>
		</table>
		</div>
		 </div>
	</div>
	</div>
	<div class="col-lg-12 col-md-12 col-dm-12 col-xs-12">
		<div class="form-group">
				<label for="condiciones">Condiciones del Servicio</label>
				<p>{{$venta->condiciones}}</p>
		</div>
	</div>
	<a href="{{URL::action('VentaController@show',$venta->idventa)}}"><button class="btn btn-primary">Imprimir</button></a>
</div>
@endsection

