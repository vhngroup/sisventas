		var total=0;
		cont=0;
		total=0;
		subtotal=[];
		$("#guardar").hide();

 $( document ).ready(function() {$('#bt_add').click(function(){agregar();
 	});
		});

function agregar()
		{
			idarticulo=$("#pidaarticulo").val();
			articulo=$("pidaarticulo option:select").text();
			cantidad=$("#pcantidad").val();
			impuesto=$("piimpuesto option:select").val(); 
			precio_compra=$("#pprecio_compra").val();
			precio_venta=$("#pprecio_venta").val();
	if(idarticulo!="" && cantidad!="" && precio_compra!="" && precio_venta!="")
	{
		subtotal[cont]=(cantidad*precio_compra);
		total=total+subtotal[cont];
		var fila='<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-warning" onclick="eliminar('+cont+');">X</button></td><td><input tipe="hidden" name="idarticulo[]" value"'+idarticulo+'">'+articulo+'</td><td><input tipe="number" name="cantidad[]" value"'+cantidad+'"></td><td><input tipe="number" name="impuesto[]" value"'+impuesto+'"></td><td><input tipe="number" name="precio_compra[]" value"'+precio_compra+'"></td><td><input tipe="number" name="precio_venta[]" value"'+precio_venta+'"></td><td>'+subtotal[cont]+'></td></tr>';
		cont++;
		limpiar();
		$("#total").html("$/. "+ total);
		evaluar();
		$('#detalles').append(fila);
	}
	else
	{
		alert("Error al ingresar el detalle del articulo, revise los datos del articulo");
	}
		}


	function limpiar()
			 {
			 alert("I am an alert box!");
			 $("#pcantidad").val("");
				$("#pprecio_compra").val("");
				$("#pprecio_venta").val("");
				// body...
			 }

function evaluar()
	{
		if(total>0)
		{
			$("#guardar").show();
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