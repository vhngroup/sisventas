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
          <img src="{{asset('imagenes/header.png')}}">
        </div>
        <div class="consignacion">
      <h1>Cotización # {{$cotizacion->num_comprobante}} del <?php $fecha_det= substr($cotizacion->fecha_hora, -24,10); echo $fecha_det; ?></h1></div>
      </div>
       <div id="alcance">Alcance: {{$cotizacion->descripcion}}</div>
    <p id="DatosClientecot">
              <span><b>Nombre del Cliente:</b> {{$cotizacion->nombrecontacto}}  <b>Identificación:</b> {{$cotizacion->tipo_documento}}:{{$cotizacion->num_documento}}</span><br><span><b>Cliente:</b> {{$cotizacion->nombre}} <b>Telefono:</b> {{$cotizacion->telefono}} <b>Correo:</b> {{$cotizacion->email}}</span><br><span> <b>Dirección:</b> {{$cotizacion->direccion}}</span>
          </p>
      <div id="consignacion">
      <p>Informaciòn de pago: Consignaciòn Bancaria: Bancolombia, cuenta de ahorros # 122-978169-59 a nombre de Victor Noguera</p> 
      <p> Regimen Comun, Nit: 1121859274-9 </p>
    </div>
  </div>
    </header>
    <section>
<table id="tablageneralcot">
   <thead>
       <tr>
            <th>Codigo</th>
            <th>Imagen</th>
            <th>Descripción</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Subtotal</th>
            <th>Descuento</th>
            <th>Iva</th>
            <th>Total</th>
        </tr>
      </thead>
   <tbody>
@foreach($detalle as $det)
      <tr>
        <td class="item">{{$det->codigo}}</td>
        <td class="imagen"> <img src="{{asset('imagenes/articulos/'.$det->imagen)}}"></td>
        <td class="descripccioncentral">{{$det->descripcion}}</td>
        <td class="cantidad">{{$det->cantidad}}</td>
        <td class="number">$ <?php echo number_format($det->precio_venta ,0,".",",");?></td>
        <td class="number">$ <?php echo number_format($det->totalgeneral ,0,".",",");?></td>
        <td class="number">$ <?php echo number_format($det->descuento ,0,".",",");?></td>    
        <td class="number">$ <?php echo number_format($det->iva ,0,".",",");?></td>
       <td  class="number">$ <?php echo number_format($det->total ,0,".",",");?></td>
      </tr>
         @endforeach
     </tbody>
</table>
</section>
<br><table style='page-break-after:auto;'></br></table><br> 
<section>
  <div>
    <table id="tabletotal">   
      <tbody>
         <?php 
      if($cotizacion->total_general >0) 
        {
          ?>
        
            <tr> 
            <td class="descripccion"></td>
            <td class="descripccion"></td>
            <td class="descripccion"></td> 
            <td class="descripccion"></td> 
            <td class="tituloresumen">Resumen Factura</td>
            <td class="descripccion">Total General</td>
            <td class="descripccion">$ <?php echo number_format($cotizacion->total_general,0,".",",");?></td>td>
          </tr>
          @if  ($cotizacion->total_descuento > 0)
          <tr>
            <td class="descripccion"></td>
            <td class="descripccion"></td>
            <td class="descripccion"></td> 
            <td class="descripccion"></td> 
            <td class="descripccion"></td> 
            <td class="descripccion">Descuento</td>
            <td class="descripccion">$ <?php echo number_format($cotizacion->total_descuento,0,".",",");?></td>
          </tr>
          @endif
          <tr>
            <td class="descripccion"></td>
            <td class="descripccion"></td>
            <td class="descripccion"></td> 
            <td class="descripccion"></td> 
            <td class="descripccion"></td> 
            <td class="descripccion">Subtotal</td>
            <td class="descripccion">$ <?php echo number_format($cotizacion->subtotal,0,".",",");?></td>
          </tr>
          <tr>
            <td class="descripccion"></td>
            <td class="descripccion"></td>
            <td class="descripccion"></td> 
            <td class="descripccion"></td> 
            <td class="descripccion"></td> 
            <td class="descripccion"> Iva 19% </td>
            <td class="descripccion">$ <?php echo number_format($cotizacion->valoriva,0,".",",");?></td>
          </tr>
          <tr>
            <td class="descripccion"></td>
            <td class="descripccion"></td>
            <td class="descripccion"></td> 
            <td class="descripccion"></td> 
            <td class="descripccion"></td> 
            <td class="descripccion">Valor Total a Pagar</td>
            <td class="descripccion" id="ptotal">$ <?php echo number_format($cotizacion->total_venta,0,".",",");?></td>
          </tr>
        <?php 
            }
            else
            {
              ?>

               <tr> 
            <td class="descripccion">Resumen Cotización</td>
            <td class="descripccion"></td>
            <td class="descripccion"></td> 
            <td class="descripccion"></td> 
            <td class="descripccion"></td> 
            <td class="descripccion">Subtotal</td>
            <td class="descripccion">$ <?php echo number_format(($cotizacion->descuento+$cotizacion->total_cotizacion)/1.19,0,".",",");?></td>
          </tr>
          <tr>
            <td class="descripccion"></td>
            <td class="descripccion"></td>
            <td class="descripccion"></td> 
            <td class="descripccion"></td> 
            <td class="descripccion"></td> 
            <td class="descripccion">Descuento</td>
            <td class="descripccion">$ <?php echo number_format($cotizacion->descuento,0,".",",");?></td>
          </tr>
          <tr>
            <td class="descripccion"></td>
            <td class="descripccion"></td>
            <td class="descripccion"></td> 
            <td class="descripccion"></td> 
            <td class="descripccion"></td> 
            <td class="descripccion">Iva 19%</td>
            <td class="descripccion">$ <?php echo number_format( ($cotizacion->total_cotizacion/1.19) * 0.19,0,".",",");?></td>
          </tr>
           <tr>
            <td class="descripccion"></td>
            <td class="descripccion"></td>
            <td class="descripccion"></td> 
            <td class="descripccion"></td> 
            <td class="descripccion"></td> 
            <td class="descripccion">Valor Total</td>
            <td class="descripccion" id="ptotal">$ <?php echo number_format($cotizacion->total_cotizacion,0,".",",");?></td>
          </tr>
      <?php
            }
        ?>
        

          </tbody>
    </table>
  </div>
</section>
<section>
      <div id="condiciones_servicio">Condiciones del servicio:</div>
     <textarea>{{$cotizacion->condiciones}}</textarea>
</section>
<footer>
            <img src="{{asset('imagenes/Footer.png')}}">
      <div id="textfooter">VHNGROUP: Tecnologia Automatizando su Hogar. - Documento creado en fisico y digital - Desarrollador VNOGUERA
      </div>
</footer>
</body>
</html>