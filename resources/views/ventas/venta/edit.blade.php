@extends('layouts.admin')
@section('contenido')
<div class="row">
	<div class="col-lg-6 col-md-6 col-dm-12 col-xs-12">
	<h3>Editor de venta {{$venta->idventa}}</h3>
{!! Form::model($venta,['method'=>'PATCH','route'=>['venta.update',$venta->idventa]]) !!}
		{{Form::token()}}
	</div>
</div>
	<div class="col-lg-12 col-md-12 col-dm-12 col-xs-12">
	<div class="table-responsive">
	<table class="table table-striped table-bordered table-condensed table-hover" id="mitabla">
	<thead>
		<th>Descripcion</th>
		<th>Cantidad</th>
		<th>Precio</th>
		<th>Descuento</th>
		<th>Valor Total</th>
		<th>Opcciones</th>
	</thead>
	<tfoot>
		<th></th>
		<th></th>
		<th></th>
		<th></th>
		<th></th>
		<th><h4 name="total" id="total">{{$venta->total_venta}}</h4></th>
	</tfoot>
	@foreach($detalles as $ven)
	<tr>	
	<td>{{$ven->articulo}}</td>
	<td><input type="number" value="{{$ven->cantidad}}" onclick="sumar()" onkeyup="sumar()" name="tcantidad" id="tcantidad" class="form-control" placeholder="cantidad"></td>

	<td type="number" name="tprecio_venta" id="tprecio_venta">{{$ven->precio_venta}}</td>

	<td><input type="number" value="{{$ven->descuento}}" onclick="sumar()" onkeyup="sumar()" name="tdescuento" id="tdescuento" class="form-control" ></td>

	<td name="tsubtotal" id="tsubtotal" class="rowDataSd">{{($ven->cantidad*$ven->precio_venta)-$ven->descuento}}</td>
	<td>
		<a href="#" data-id ="{{$ven->id}}" data-articulo ="{{$ven->idarticulo}}" data-cantidad ="{{$ven->cantidad}}", class="btn btn-danger btn-xs btn-delete">Eliminar</a>
		</form>
	</td> 
	@endforeach
	</table>
	</div>
	<a href="" data-target="#modal-cancelar-{{$venta->idventa}}" data-toggle="modal"><button class="btn btn-danger">Anular</button></a> 
		    <a href="{{URL::action('VentaController@crear_pdf',$venta->idventa)}}" target=newtab "><button class="btn btn-primary">Imprimir</button></a>
		    <a class="btn btn-default" href="/ventas/venta" role="button">Regresar</a>
	</div>
</div>

{{ Form::open(array('route' => array('venta.destroy', 'id'), 'method' => 'DELETE', 'role' => 'form', 'id' => 'form-delete')) }}

{{ Form::close() }}
	@push ('scripts')
		<script>			
			$(window).ready(function() {
	   		if ($('.btn-delete').length) {
	      	$('.btn-delete').click(function() {
	         var id = $(this).data('id');
	         var form = $('#form-delete');
	         var action = form.attr('action').replace('id', id);
	         var row =  $(this).parents('tr');
	         row.fadeOut(1000);
	         $.post(action, form.serialize(), function(result) {
	            if (result.success) {
	               setTimeout (function () {
	                  row.delay(1000).remove();
	                  alert(result.msg);
	               }, 1000);                
	            } else {
	               row.show();
	            }
	         }, 'json');
	      });
	   }
	}); 
			var ttotal=0;
			function sumar () {
			tprecioventa=$("#tprecio_venta").text();
			tcantidad=$("#tcantidad").val();
			tdescuento=$("#tdescuento").val();
			tsubtotal= ((tprecioventa*tcantidad)-tdescuento);
			$("#tsubtotal").text(tsubtotal);

			var ttotal += parseInt(document.getElementById("#tsubtotal").value);
			//$("#total").text(ttotal);						
		};		
		
		</script>
@endpush
@endsection


	