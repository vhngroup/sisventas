<!DOCTYPE html> 
<html lang="es">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
    <title>Orden de Compra # {{$pedido->idpedido}}</title>
    <link rel="stylesheet" href="{{asset('css/style.css')}}" media="all" />
  </head>
  <body>
    <header>
      <div class="header">
      <div id="logo">
              <img src="{{asset('imagenes/Logo.png')}}">
      </div>
      <div>
      <h1>Orden de Compra # {{$pedido->num_comprobante}}-{{$pedido->idpedido}} del <?php $fecha_det= substr($pedido->fecha_hora, -24,10); echo $fecha_det; ?></h1>
       <div id="pago">
      </div>
    <div id="DatosCliente">
        <p><b>Proveedor: </b> {{$pedido->nombre}} <b>Identificación: </b> {{$pedido->tipo_documento}} <b>Numero: </b> {{$pedido->num_documento}}</p>
        <p><b>Nombre de la persona de contacto: </b>{{$pedido->nombrecontacto}}</p>
            <p><b>Telefono: </b> {{$pedido->telefono}} <b>Correo: </b> {{$pedido->email}} <b>Dirección: </b>
        {{$pedido->direccion}}</p>
      </div>
  </div>
  </div>
    </header>
    <section>
<table style="table 
  {
    width: 100%;
    border-collapse: collapse;
    position: relative;
    top: 19%;
    margin-bottom: 80px;
    
  }">
   <thead>
       <tr>
            <th>Codigo</th>
            <th>Imagen</th>
            <th">Descripcción</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Total</th>
        </tr>
      </thead>
   <tbody>
@foreach($detalle as $det)
      <tr>
        <td class="item">{{$det->codigo}}</td>
        <td class=""> <img src="{{asset('imagenes/articulos/'.$det->imagen)}}"></td>
        <td class="item">{{$det->descripcion}}</td>
        <td class="number">{{$det->cantidad}}</td>
        <td class="item">$ <?php echo number_format($det->precio_venta ,1,".",",");?></td>
        <td class="item">$ <?php echo number_format($det->cantidad*$det->precio_venta ,1,".",",");?></td>
      </tr>
         @endforeach
     </tbody>
</table>
</section>
<br><table style='page-break-after:auto;'></br></table><br> 
<section>
  <div id="tabletotal">
    <table id="tableinterna" style="position: static;">   
        <tbody>
            <tr> 
            <td class="descripccion">Resumen orden de compra</td>
            <td class="descripccion"></td>
            <td class="descripccion"></td> 
            <td class="descripccion"></td> 
            <td class="descripccion"></td> 
            <td class="descripccion">Subtotal</td>
            <td class="descripccion">$ <?php echo number_format(ceil($pedido->total_venta) ,2,".",",");?></td>
          </tr>
          <tr>
            <td class="descripccion"></td>
            <td class="descripccion"></td>
            <td class="descripccion"></td> 
            <td class="descripccion"></td> 
            <td class="descripccion"></td> 
            <td class="descripccion">Descuento</td>
            <td class="descripccion">$ 0</td>
          </tr>
          <tr>
             <td class="descripccion"></td>
            <td class="descripccion"></td>
            <td class="descripccion"></td> 
            <td class="descripccion"></td> 
            <td class="descripccion"></td> 
            <td class="descripccion">Iva 19%</td>
            <td class="descripccion">$ <?php echo number_format((($pedido->total_venta)*1.19)-($pedido->total_venta) ,2,".",",");?></td>
          </tr>
          <tr>
          <td class="descripccion"></td>
            <td class="descripccion"></td>
            <td class="descripccion"></td> 
            <td class="descripccion"></td> 
            <td class="descripccion"></td> 
            <td class="descripccion">Anticipo</td>
            <td class="descripccion">$ 0</td>
          </tr>
            <tr>
            <td class="descripccion"></td>
            <td class="descripccion"></td>
            <td class="descripccion"></td> 
            <td class="descripccion"></td> 
            <td class="descripccion"></td> 
            <td class="descripccion">Valor Total</td>
            <td class="descripccion" id="ptotal">$ <?php echo number_format(($pedido->total_venta * 1.19),2,".",",");?></td>
          </tr>
          </tbody>
    </table>
  </div>
</section>
<section>
      <div id="titulodescripccion">Condiciones del servicio:</div>
     <textarea>{{$pedido->condiciones}}</textarea>
</section>
<footer>
            <img src="{{asset('imagenes/Footer.png')}}">
      <div id="textfooter">VHNGROUP: Tecnologia Automatizando su Hogar. - Factura creada en fisico y digital - Desarrollador VNOGUERA
      </div>
</footer>
</body>
</html>