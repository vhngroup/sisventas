@extends('layouts.admin')
@section('contenido')
<div class="row">	
	<div class="col-lg-6 col-md-6 col-dm-12 col-xs-12">
		<div class="form-group">
			  <label for="nombre">Cliente</label>
            <p>{{$cotizacion->nombre}}</p>
			</select>
		</div>
	</div>
	<div class="col-lg-6 col-md-6 col-dm-12 col-xs-12">
		<div class="form-group">
			  <label for="nombre">Alcance</label>
            <p>{{$cotizacion->descripccion}}</p>
			</select>
		</div>
	</div>

	<div class="col-lg-3 col-md-4 col-dm-12 col-xs-12">
		<div class="form-group">
				<label for="serie_comprobante">Serie Comprobante</label>
				<p>{{$cotizacion->serie_comprobante}}</p>
		</div>
	</div>

	<div class="col-lg-3 col-md-4 col-dm-12 col-xs-12">
		<div class="form-group">
				<label for="numero_comprobante">Numero de Comprobante</label>
				<p>{{$cotizacion->num_comprobante}}</p>
		</div>
	</div>	

	<div class="col-lg-3 col-md-4 col-dm-12 col-xs-12">
		<div class="form-group">
				<label for="anticipo">Fecha de realizacion</label>
				<p>{{$cotizacion->fecha_hora}}</p>
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
					<th>Precio cotizacion</th>
					<th>descuento</th>
					<th>Subtotal</th>
				</thead>
			<tfoot>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
					<th><h4 id="total">{{$cotizacion->total_venta}}</h4></th>
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
		<div class="col-lg-12 col-md-12 col-dm-12 col-xs-12">
		<div class="form-group">
				<label for="condiciones">Condiciones del Servicio</label>
				<p>{{$cotizacion->condiciones}}</p>
		</div>
	</div>
		</div>
		 <a href="{{URL::action('CotizacionController@crear_pdf',$cotizacion->idcotizacion)}}"><button class="btn btn-primary">Imprimir</button></a>
		 <a class="btn btn-default" href="/cotizaciones" role="button">Cancelar</a>
		 <a class="btn btn-default" href="/ventas/venta" role="button">Regresar</a>
	</div>
	</div>
	</div>
</div>
@endsection

