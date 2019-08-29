@extends('layouts.admin')
@section('contenido')
<div class="row">
	<div class="col-lg-6 col-md-6 col-dm-12 col-xs-12">
	<h3>Nueva Venta</h3>
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
		{!!Form::open(array('url'=>'ventas/venta','method'=>'POST','autocomplete'=>'off'))!!}
            {{Form::token()}}
<div class="row">
	<div class="col-lg-12 col-md-12 col-dm-12 col-xs-12">
		<div class="form-group">
				<label for="proyecto">Seleccione proyecto al que pertenece</label>
	             <select name="idproyecto" id="idproyecto" class="form-control selectpicker" data-size="5" data-live-search="true">
	              @foreach($dataproyecto as $proyecto)
	              <option value="{{$proyecto->idproyecto}}_{{$proyecto->nombre}}_{{$proyecto->descripcion}}_{{$proyecto->idpersona}}">{{$proyecto->descripcion}} |-| {{$proyecto->nombre}}</option>
	              @endforeach              
				</select>
			</div>
		</div>
<div class="col-lg-6 col-md-6 col-dm-12 col-xs-12">
	<div class="form-group">
			  <label for="nombre">Cliente</label>
             <select name="idcliente" id="idcliente" class="form-control selectpicker" data-size="5" data-live-search="true">
              @foreach($personas as $persona)
              <option value="{{$persona->idpersona}}">{{$persona->nombre}}</option>
              @endforeach
			</select>
		</div>
</div>

<div class="col-lg-6 col-md-6 col-dm-12 col-xs-12">
	<div class="form-group">
			<label for="descripcion">Alcance del Servicio:</label>
			<input type="text" name="descripcion" id="descripcion" required value="{{old('descripcion, descripcion')}}" maxlength="100" class="form-control" placeholder="Describa el alcance del Servicio">
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
				<label for="num_comprobante">Numero de Factura</label>
				<input type="text" name="num_comprobante" required readonly value= "{{$idventa}}" class="form-control" placeholder="Numero de factura">
		</div>
	</div>	

<div class="col-lg-3 col-md-4 col-dm-12 col-xs-12">

		<div class="form-group">
				<label for="anticipo">Anticipo</label>
				<input type="text" name="anticipo" required value="{{old('anticipo', 0)}}" class="form-control" placeholder="Valor anticipo...">
		</div>
	</div>
</div>	

<div class="row">
<div class="panel panel-primary">
<div class="panel-body">
	
<div class="col-lg-2 col-md-2 col-dm-12 col-xs-12">
	<div class="form-group">	
	<label>Articulo</label>
	<select name="pidarticulo" id="pidarticulo" class="form-control selectpicker" data-size="5"  data-live-search="true">
		@foreach($articulos as $articulo)
		<option value= "{{$articulo->idarticulo}}_{{$articulo->stock}}_{{$articulo->precio_promedio}}_{{$articulo->impuesto}}">{{$articulo->articulo}}</option>
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
		<label for="pstock">Stock</label>
		<input type="number" readonly name="pstock" id="pstock" class="form-control" placeholder="Stock">
		</div>
	</div>

	<div class="col-lg-2 col-md-2 col-dm-12 col-xs-12">
	<div class="form-group">
	<label for="impuesto">% impuesto</label>
	<input type="number"  name="pimpuesto" id="pimpuesto" class="form-control">
	</div>
	</div>
	<div class="col-lg-2 col-md-2 col-dm-12 col-xs-12">
		<div class="form-group">
		<label for="precio_venta">Precio de venta</label>
		<input type="text" readonly name="pprecio_venta" id="pprecio_venta" class="form-control" placeholder="precio de venta">
		</div>
	</div>

	<div class="col-lg-2 col-md-2 col-dm-12 col-xs-12">
		<div class="form-group">
		<label for="descuento">Descuento</label>
		<input type="number" name="pdescuento" value="0" id="pdescuento" class="form-control" placeholder="Descuento">
		</div>
	</div>

	<div class="col-lg-12 col-md-12 col-dm-12 col-xs-12">
		<div class="form-group">
		<button class="btn btn-primary" type="button"  id="bt_agregar" onclick="evaluar()" >Agregar</button>
		</div>
	</div>
	<div class="col-lg-12 col-md-12 col-dm-12 col-xs-12">
		  <div class="table-responsive">
		<table id="detalles"  class="table table-striped table-bordered table-condensed table-hover" style="font-size: 12px">
			<thead style="background-color:#caf5a9">
			<th class="col-sm-1">Opc</th>
			<th class="col-sm-3">Articulo</th>
			<th class="col-sm-1">Cantidad</th>
			<th class="col-sm-2">Precio Venta</th>
			<th class="col-sm-1">Descuento</th>
			<th class="col-sm-1">SubTotal</th>
			<th class="col-sm-2">Iva</th>
			<th class="col-sm-2">Total</th>
		</thead>
			<tfoot>
				<th>Total</th>
				<th></th>
				<th></th>
				<th class="col-sm-2"><input  id="totalgeneral" name="totalgeneral" value="0" readonly="true"></th>
				<th class="col-sm-1"><input  id="totaldescuento" name="totaldescuento" value="0" readonly="true"></th>
				<th class="col-sm-1"><input  id="subtotal" name="subtotal" value="0" readonly="true"></th>
				<th class="col-sm-2"><input  id="valoriva" name="valoriva" value="0" readonly="true"></th>
				<th class="col-sm-2"><input  id="totalventa" name="totalventa" value="0" readonly="true"></th>
			</tfoot>
		<tbody>
		</tbody>
		</table>
		</div>
	</div>
	</div>
	</div>
<div class="col-lg-12 col-md-12 col-dm-12 col-xs-12">
		<div class="form-group">
		<label for="condiciones">Condiciones del Servicio</label>
		<textarea type="text" name="condiciones" id="condiciones" class="form-control" placeholder="condiciones"></textarea>
	</div>
</div>
<div class="col-lg-6 col-md-6 col-dm-6 col-xs-12" id="guardar1">
	<div class="form-group">
		<input name="_token" value="{{ csrf_token() }}" type="hidden"></input>
		<button id="guardar" onclick="validastate()" class="btn btn-primary"  type="submit">Guardar</button>
		<button class="btn btn-danger" type="reset">Restablecer</button>
		<a class="btn btn-primary" href="/ventas/venta" role="button">Cancelar</a>
			</div>
		</div>
	</div>
   		{!!Form::close()!!}  
         @push ('scripts')
		<script>
		var total=0, totalSubtotal=0, totalGeneral=0, totalIva=0, totalDescuento=0;
		cont=0;
		acm_Totalgeneral=[];
		acm_Subtotal=[];
		acm_Iva=[];
		acm_Descuento=[];
		acm_Total=[];
		$(document).on('ready',function(){
			 var x= document.getElementById('idproyecto');
			 var option = document.createElement("option");
			 option.text = "Por Favor seleccione Opccion";
			 x.add(option, x[0]);
			 document.getElementById('idproyecto').selectedIndex=0;
			mostrarproyecto();
			mostrarValores();
			state=1;
		});
		$("#pidarticulo").change(mostrarValores);
		$("#idproyecto").change(mostrarproyecto);
		$("#guardar").hide();

		function mostrarValores()
		{
			state=0;
			datosArticulo=document.getElementById('pidarticulo').value.split('_');
			$("#pprecio_venta").val(datosArticulo[2]);
			$("#pstock").val(datosArticulo[1]);
			$("#pimpuesto").val(datosArticulo[3]);
		}

		function mostrarproyecto()
		{
			state=0;
			datosProyecto=document.getElementById('idproyecto').value.split('_');
			$("#descripcion").val(datosProyecto[2])
			$('select[name=idcliente]').val(datosProyecto[3]);
   			$('select[name=idcliente]').change();
		}

function agregar()
		{
			datosArticulo=document.getElementById('pidarticulo').value.split('_');
			idarticulo=datosArticulo[0];
			articulo=$("#pidarticulo option:selected").text();
			stock=$("#pstock").val();
			cantidad=$("#pcantidad").val();
			impuesto=$("#pimpuesto").val(); 
			descuento=$("#pdescuento").val();
			precio_venta=$("#pprecio_venta").val();
			
			  if (idarticulo!="" && cantidad!="" && cantidad>0 && descuento!="" && precio_venta!="")
		{
			if(Number(stock)>=Number(cantidad))
			{
				acm_Totalgeneral[cont]=Math.round((cantidad*precio_venta)*100)/100;
				acm_Descuento[cont]=Math.round(descuento*100)/100;
				acm_Subtotal[cont]=Math.round(((cantidad*precio_venta)-descuento)*100)/100;
				acm_Iva[cont]=Math.round((((cantidad*precio_venta)-descuento)/100*impuesto)*100)/100;
				acm_Total[cont]=Math.round((acm_Subtotal[cont]+acm_Iva[cont])*100)/100;
				totalGeneral=Math.round((totalGeneral+acm_Totalgeneral[cont])*100)/100;
				totalDescuento=Math.round((totalDescuento + acm_Descuento[cont])*100)/100;
				totalSubtotal=Math.round((totalSubtotal+acm_Subtotal[cont])*100)/100;
				totalIva=Math.round((acm_Iva[cont]+totalIva)*100)/100;
				total=Math.round(((total+acm_Subtotal[cont])+acm_Iva[cont])*100)/100;
			var fila='<tr class="selected" id="fila'+cont+'" style="font-size: 11px"><td><button type="button" class="btn btn-warning" onclick="eliminar('+cont+');">X</button></td><td><input type="hidden" name="idarticulo[]" value="'+idarticulo+'">'+articulo+'</td><td><input type="number" name="cantidad[]" readonly value="'+cantidad+'"></td><td><input type="number" name="acm_Totalgeneral[]" readonly value="'+acm_Totalgeneral[cont]+'"><td><input type="number"name="acm_Descuento[]" value="'+acm_Descuento[cont]+'"></td><td><input type="number"name="acm_Subtotal[]" value="'+acm_Subtotal[cont]+'"></td><td><input name="acm_Iva[]" value="'+acm_Iva[cont]+'"></td><td><input name="acm_Total[]" value="'+acm_Total[cont]+'"></td><input name="precio_venta[]" type="hidden" value="'+precio_venta+'"></tr>';
			cont++;
		  	$('#totalgeneral').html ("$/ "  +totalGeneral); 
			$('#totaldescuento').html("$/ " +totalDescuento);
			$('#subtotal').html("$/ " +totalSubtotal);
			$('#valoriva').html("$/ "+totalIva);
			$('#totalventa').html("$/ "+total);
			$('#totalgeneral').val(totalGeneral);
			$('#totaldescuento').val(totalDescuento);
			$('#subtotal').val(totalSubtotal);
			$('#valoriva').val(totalIva);
			$('#totalventa').val(total);
			$('#detalles').append(fila);
		  	limpiar();
		  	$('select[name=pidarticulo]').val(1);
			$('.selectpicker').selectpicker('refresh');
			mostrarValores();
			$("#guardar").show();
		  }
		else
		{
			alert('la cantidad a vender supera el stock');
			state=0;
		}
		}
	else
	{
		alert("Error al ingresar el detalle de la venta, revise los datos del articulo");
		state=0;
	}
		}

	function limpiar()
			 {
			 	state=0;
			    $("#pcantidad").val("");
				$("#pdescuento").val(0);
				$("#pprecio_venta").val("");
				$("#pstock").val("");
			 }
			 
	function evaluar()
	{
		state =0;
		var pproyecto = document.getElementById('idproyecto').selectedIndex;
		var indice = document.getElementById('idcliente').selectedIndex;
		var descripcion = document.getElementById('descripcion').value;
		 if (pproyecto<=0) //evalua si el proyecto esta seleccionado
	 
			{
				alert("Por favor seleccione un proyecto")
						$("#guardar").hide();	
			}
		else { //si la respuesta es positiva evalua siguiente nivel
			if (descripcion=="") //evalua si la descripcción es activa
				{
						alert("Por favor ingrese una descripcion")
						$("#guardar").hide();
				}
				else
				{
					if (indice<=0)	//evalua si hay cliente
					{
						alert("Debe seleccionar un cliente")
						$("#guardar").hide();	
					}
					else //pasa todo ok
					{	
						agregar();		
					}
				}
			}
	}

	function eliminar(index){
		state=0;
		totalGeneral=Math.round((totalGeneral-acm_Totalgeneral[index])*100)/100;
		totalDescuento=Math.round((totalDescuento - acm_Descuento[index])*100)/100;
		totalSubtotal=Math.round((totalSubtotal-acm_Subtotal[index])*100)/100;
		totalIva=Math.round((totalIva-acm_Iva[index])*100)/100;
		total=Math.round((total-acm_Subtotal[index]-acm_Iva[index])*100)/100;

		$('#totalgeneral').html ("$/ "  +totalGeneral); 
		$('#totaldescuento').html("$/ " +totalDescuento);
		$('#subtotal').html("$/ " +totalSubtotal);
		$('#valoriva').html("$/ "+totalIva);
		$('#totalventa').html("$/ "+total);
		$('#totalgeneral').val(totalGeneral);
		$('#totaldescuento').val(totalDescuento);
		$('#subtotal').val(totalSubtotal);
		$('#valoriva').val(totalIva);
		$('#totalventa').val(total);
	$('#fila'+index).remove();
	evaluar();
		}

window.addEventListener('beforeunload', function (e) {
			if (state ===1)
			{	

			}
				else
			{
						e.preventDefault();
		    			e.returnValue = '';
			}
			});
	function validastate()	
	{
		state=1;
	}
</script>
@endpush
@endsection



