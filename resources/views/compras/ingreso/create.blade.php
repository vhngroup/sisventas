@extends('layouts.admin')
@section('contenido')
<div class="row">
	<div class="col-lg-6 col-md-6 col-dm-12 col-xs-12">
	<h3>Nuevo Ingreso</h3>
	@if(count($errors)>0)
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors-> all() as $error) 
					<li>
					{{$error}}
					</li>
				@endforeach
			</ul>
		</div>
		@endif
	</div>
</div>
		{!!Form::open(array('url'=>'compras/ingreso','method'=>'POST','autocomplete'=>'off'))!!}
            {{Form::token()}}
<div class="row">	
<div class="col-lg-12 col-md-6 col-dm-12 col-xs-12">
	<div class="form-group">
			  <label for="nombre">Proveedor</label>
             <select name="idproveedor" id="idproveedor" class="form-control selectpicker" data-live-search="true">
              @foreach($personas as $persona)
              <option value="{{$persona->idpersona}}">{{$persona->nombre}}</option>
              @endforeach
			</select>
		</div>
</div>

<div class="col-lg-3 col-md-4 col-dm-12 col-xs-12">
	<div class="form-group">
			<label>Tipo de Comprobante</label>
			<select name="tipo_comprobante" class="form-control">
				<option value="Factura"> Factura </option>
				<option value="Boleta"> Boleta </option>
				<option value="Ticket"> Ticket </option>
			</select>
		</div>
</div>

<div class="col-lg-3 col-md-4 col-dm-12 col-xs-12">
	<div class="form-group">
			<label for="serie_comprobante">Serie Comprobante</label>
			<input type="text" name="serie_comprobante" readonly value="<?php echo date("Y-m-d");?>" class="form-control" placeholder="Serie de comprobante...">
	</div>
</div>

	<div class="col-lg-3 col-md-4 col-dm-12 col-xs-12">
		<div class="form-group">
				<label for="numero_comprobante">Numero de Comprobante</label>
				<input type="text" name="numero_comprobante" required readonly value= "{{$iingreso}}" class="form-control" placeholder="Numero de comprobante...">
		</div>
	</div>	

<div class="col-lg-3 col-md-4 col-dm-12 col-xs-12">
		<div class="form-group">
				<label for="anticipo">Anticipo</label>
				<input type="text" name="anticipo" required value="{{old('anticipo')}}" class="form-control" placeholder="Valor anticipo...">
		</div>
	</div>
</div>	

<div class="row">
<div class="panel panel-primary">
<div class="panel-body">
	
<div class="col-lg-2 col-md-2 col-dm-12 col-xs-12">
	<div class="form-group">	
	<label>Articulo</label>
	<select name="pidaarticulo" id="pidaarticulo" class="form-control selectpicker"  data-live-search="true">
		@foreach($articulos as $articulo)
		<option value="{{$articulo->idarticulo}}">{{$articulo->articulo}}</option>
		@endforeach
	</select>
	</div>
	</div>	
	<div class="col-lg-2 col-md-2 col-dm-12 col-xs-12">
		<div class="form-group">
		<label for="cantidad">Cantidad</label>
		<input type="number" name="pcantidad" id="pcantidad" class="form-control" placeholder="Cantidad">
		</div>
	</div>

	<div class="col-lg-2 col-md-2 col-dm-12 col-xs-12">
		<div class="form-group">
		<label for="precio_compra">Precio de Compra</label>
		<input type="number" name="pprecio_compra" id="pprecio_compra" class="form-control" placeholder="precio de compra">
			</div>
	</div>

	<div class="col-lg-2 col-md-2 col-dm-12 col-xs-12">
		<div class="form-group">
		<label for="precio_venta">Precio de venta</label>
		<input type="number" name="pprecio_venta" id="pprecio_venta" class="form-control" placeholder="precio de venta">
			</div>
	</div>
	<div class="col-lg-2 col-md-2 col-dm-12 col-xs-12">
	<div class="form-group">
		<label for="impuesto">impuesto</label>
			<select name="impuesto" id="piimpuesto" class="form-control">
			@foreach($impuestos as $impuesto)
			<option value= "{{$impuesto->porcentaje}}">{{$impuesto->descripccion}}</option>
			@endforeach
			</select>
		</div>
	</div>
	<div class="col-lg-2 col-md-2 col-dm-12 col-xs-12">
		<div class="form-group">
		<button class="btn btn-primary" type="button"  id="bt_agregar" onclick="agregar()">Agregar</button>
		</div>
	</div>
	<div class="col-lg-12 col-md-12 col-dm-12 col-xs-12">
		  <div class="table-responsive">
		<table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
			<thead style="background-color:#caf5a9">
			<th>Opcciones</th>
			<th>Articulo</th>
			<th>Cantidad</th>
			<th>impuesto</th>
			<th>Precio Compra</th>
			<th>Precio Venta</th>
			<th>Subtotal</th>
		</thead>
			<tfoot>
				<th>Total</th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th><h4 id="total">$/. 0.00</h4></th>
			</tfoot>
		<tbody></tbody>
		</table>
		</div>
	</div>
	</div>
	</div>
		<div class="col-lg-6 col-md-6 col-dm-6 col-xs-12" id="guardar">
					<div class="form-group">
				<input name="_token" value="{{ csrf_token() }}" type="hidden"></input>
						<button class="btn btn-primary"  type="submit">Guardar</button>
						<button class="btn btn-danger" type="reset">Cancelar</button>
					</div>
				</div>
		</div>
   		{!!Form::close()!!}  
         @push ('scripts')
		<script>
		var total=0;
		cont=0;
		total=0;
		subtotal=[];
		$("#guardar").hide();

function agregar()
		{
			idarticulo=$("#pidaarticulo").val();
			articulo=$("#pidaarticulo option:selected").text();
			cantidad=$("#pcantidad").val();
			impuesto=$("#piimpuesto option:selected").val(); 
			precio_compra=$("#pprecio_compra").val();
			precio_venta=$("#pprecio_venta").val();
			  if (idarticulo!="" && cantidad!="" && cantidad>0 && precio_compra!="" && precio_venta!="")
		{
		subtotal[cont]=(cantidad*precio_compra);
		total=total+subtotal[cont];
		var fila='<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-warning" onclick="eliminar('+cont+');">X</button></td><td><input type="hidden" name="idarticulo[]"  value="'+idarticulo+'">'+articulo+'</td><td><input type="number" name="cantidad[]" readonly value="'+cantidad+'"></td><td><input name="impuesto[]" readonly value="'+impuesto+'"></td><td><input type="number" name="precio_compra[]" readonly value="'+precio_compra+'"></td><td><input type="number"name="precio_venta[]" readonly value="'+precio_venta+'"></td><td>'+subtotal[cont]+'</td></tr>';
		cont++;
		evaluar();
		limpiar();
		    $('#total').html("$/ " + total);
		  $('#detalles').append(fila);
		
		}
	else
	{
		alert("Error al ingresar el detalle del articulo, revise los datos del articulo");
	}
		}


	function limpiar()
			 {
			    $("#pcantidad").val("");
				$("#pprecio_compra").val("");
				$("#pprecio_venta").val("");
			 }

			function evaluar()
				{
				var indice = document.getElementById('idproveedor').selectedIndex
					if(total>0)
					{
						if(indice=0)
						{
							alert("Debe seleccionar un cliente")
						}
						else
						{
							$("#guardar").show();
						}
					}
					else
					{
						$("#guardar").hide();
					}	
				}

	function eliminar(index){
	total=total-subtotal[index];
	$('#total').html("$/. "+total);
	$('#fila'+index).remove();
	evaluar();
		}


</script>
@endpush
@endsection

