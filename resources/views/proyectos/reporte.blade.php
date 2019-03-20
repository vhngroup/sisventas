<!DOCTYPE html> 
<html lang="es">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
    <title>Propuesta de cotización # {{$cotizacion->idcotizacion}}</title>
    <link rel="stylesheet" href="{{asset('css/style.css')}}" media="all" />
  </head>
  <body>
    <header>
      <div class="header">
      <div id="logo">
              <img src="{{asset('imagenes/Logo.png')}}">
      </div>
      <div>
      <h1>Cotización # {{$cotizacion->num_comprobante}}{{$cotizacion->serie_comprobante}}-{{$cotizacion->idcotizacion}} del <?php $fecha_det= substr($cotizacion->fecha_hora, -24,10); echo $fecha_det; ?></h1>
       <div id="pago">
       <p><h3>Informaciòn de pago: Consignaciòn Bancaria: Bancolombia, cuenta de ahorros # 122-978169-59 a nombre de Victor Hugo Noguera</h3>
      <h3>Regimen simplificado a Nombre de Victor Hugo Noguera Lievano Nit: 1121859274-9</h3></p>
      </div>
       <div id="alcance">Alcance: {{$cotizacion->descripccion}}</div>

    <div id="DatosCliente">
        <p><b>Cliente: </b> {{$cotizacion->nombre}} <b>Identificación: </b> {{$cotizacion->tipo_documento}} <b>Numero: </b> {{$cotizacion->num_documento}}</p>
        <p><b>Nombre del Cliente: </b>{{$cotizacion->nombrecontacto}}</p>
            <p><b>Telefono: </b> {{$cotizacion->telefono}} <b>Correo: </b> {{$cotizacion->email}} <b>Dirección: </b>
        {{$cotizacion->direccion}}</p>
      </div>
  </div>
  </div>
    </header>
    <section>
<table>
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
        <td class="item">{{$det->descripccion}}</td>
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
            <td class="descripccion">Resumen Factura</td>
            <td class="descripccion"></td>
            <td class="descripccion"></td> 
            <td class="descripccion"></td> 
            <td class="descripccion"></td> 
            <td class="descripccion">Subtotal</td>
            <td class="descripccion">$ <?php echo number_format($cotizacion->total_venta,1,".",",");?></td>
          </tr>
          <tr>
            <td class="descripccion"></td>
            <td class="descripccion"></td>
            <td class="descripccion"></td> 
            <td class="descripccion"></td> 
            <td class="descripccion"></td> 
            <td class="descripccion">Impuestos</td>
            <td class="descripccion">$ 0</td>
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
            <td class="descripccion">Valor Total</td>
            <td class="descripccion" id="ptotal">$ <?php echo number_format($cotizacion->total_venta,1,".",",");?></td>
          </tr>
          </tbody>
    </table>
  </div>
</section>
<section>
      <div id="titulodescripccion">Condiciones del servicio:</div>
     <textarea>{{$cotizacion->condiciones}}</textarea>
</section>
<footer>
            <img src="{{asset('imagenes/Footer.png')}}">
      <div id="textfooter">VHNGROUP: Tecnologia Automatizando su Hogar. - Factura creada en fisico y digital - Desarrollador VNOGUERA
      </div>
</footer>
</body>
</html>