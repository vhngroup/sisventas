<!DOCTYPE html>
<html lang="es">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
    <title>Factura de Venta # {{$venta->num_comprobante}}</title>
    <link rel="stylesheet" href="{{asset('css/style.css')}}" media="all" />
   </head>
  <body>
    <header>
      <div class="header">
      <div id="logo">
        <img src="{{asset('imagenes/Logo.png')}}">
      </div>
      <div>
      <div id="pago">
        <h1>Factura de Venta # {{$venta->num_comprobante}} del <?php $fecha_det= substr($venta->fecha_hora, -24,10); echo $fecha_det; ?></h1>
      </div>
      <div id="resolucion">Resolución de facturación 18763000813132 consecutivos del 1001 al 1150 Habilitada por 24 meses desde el 2019-10-02 hasta 02/10/2021</div>
      <div id="alcance"><b>Alcance: </b>{{$venta->descripcion}}</div>
        <div id="DatosCliente">
        <p><b>Cliente:</b> {{$venta->nombre}} <b>Identificación:</b> {{$venta->tipo_documento}} <b>Numero:</b> {{$venta->num_documento}}</p>
        <p><b>Nombre del Cliente:</b> {{$venta->nombrecontacto}}</p>
            <p><b>Telefono:</b> {{$venta->telefono}} <b>Correo:</b> {{$venta->email}} <b>Dirección:</b>
        {{$venta->direccion}}</p>
      </div>
      <div id="consignacion">
      <p>Informaciòn de pago: Consignaciòn Bancaria: Bancolombia, cuenta de ahorros # 122-978169-59 a nombre de Victor Noguera</p> 
      <p> Regimen Comun, Nit: 1121859274-9 </p>
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
        <td class=""> <img src="{{asset('imagenes/articulos/'.$det->imagen)}}"></td>
        <td class="item">{{$det->descripcion}}</td>
        <td class="number">{{$det->cantidad}}</td>
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
<div id="tabletotal">
    <table id="tableinterna" style="position: static;"> 
        <tbody>
           <?php 
      if($venta->total_general >0) 
        {
          ?>
        
            <tr> 
            <td class="descripccion">Resumen Factura</td>
            <td class="descripccion"></td>
            <td class="descripccion"></td> 
            <td class="descripccion"></td> 
            <td class="descripccion"></td> 
            <td class="descripccion">Total General</td>
            <td class="descripccion">$ <?php echo number_format($venta->total_general,0,".",",");?></td>td>
          </tr>
          <tr>
            <td class="descripccion"></td>
            <td class="descripccion"></td>
            <td class="descripccion"></td> 
            <td class="descripccion"></td> 
            <td class="descripccion"></td> 
            <td class="descripccion">Descuento</td>
            <td class="descripccion">$ <?php echo number_format($venta->total_descuento,0,".",",");?></td>
          </tr>
          <tr>
            <td class="descripccion"></td>
            <td class="descripccion"></td>
            <td class="descripccion"></td> 
            <td class="descripccion"></td> 
            <td class="descripccion"></td> 
            <td class="descripccion">Subtotal</td>
            <td class="descripccion">$ <?php echo number_format($venta->subtotal,0,".",",");?></td>
          </tr>
          <tr>
            <td class="descripccion"></td>
            <td class="descripccion"></td>
            <td class="descripccion"></td> 
            <td class="descripccion"></td> 
            <td class="descripccion"></td> 
            <td class="descripccion"> Iva 19% </td>
            <td class="descripccion">$ <?php echo number_format($venta->valoriva,0,".",",");?></td>
          </tr>
          <tr>
            <td class="descripccion"></td>
            <td class="descripccion"></td>
            <td class="descripccion"></td> 
            <td class="descripccion"></td> 
            <td class="descripccion"></td> 
            <td class="descripccion">Valor Total a Pagar</td>
            <td class="descripccion" id="ptotal">$ <?php echo number_format($venta->total_venta,0,".",",");?></td>
          </tr>
        <?php 
            }
            else
            {
              ?>

            <tr> 
            <td class="descripccion">Resumen Factura de venta</td>
            <td class="descripccion"></td>
            <td class="descripccion"></td> 
            <td class="descripccion"></td> 
            <td class="descripccion"></td> 
            <td class="descripccion">Subtotal</td>
            <td class="descripccion">$ <?php echo number_format(($venta->descuento+$venta->total_venta)/1.19,0,".",",");?></td>
          </tr>
          <tr>
            <td class="descripccion"></td>
            <td class="descripccion"></td>
            <td class="descripccion"></td> 
            <td class="descripccion"></td> 
            <td class="descripccion"></td> 
            <td class="descripccion">Descuento</td>
            <td class="descripccion">$ <?php echo number_format($venta->descuento,0,".",",");?></td>
          </tr>
          <tr>
            <td class="descripccion"></td>
            <td class="descripccion"></td>
            <td class="descripccion"></td> 
            <td class="descripccion"></td> 
            <td class="descripccion"></td> 
            <td class="descripccion">Iva 19%</td>
            <td class="descripccion">$ <?php echo number_format( ($venta->total_venta/1.19) * 0.19,0,".",",");?></td>
          </tr>
           <tr>
            <td class="descripccion"></td>
            <td class="descripccion"></td>
            <td class="descripccion"></td> 
            <td class="descripccion"></td> 
            <td class="descripccion"></td> 
            <td class="descripccion">Valor Total</td>
            <td class="descripccion" id="ptotal">$ <?php echo number_format($venta->total_venta,0,".",",");?></td>
          </tr>
          <?php
            }
        ?>
          </tbody>
    </table>
   </div>
</section>
<section>
      <div id="titulodescripccion">Condiciones del servicio:</div>
      <?php 
          if($venta->anticipo > 0)
          {
    ?>
        <textarea id="descripccion"><strong>Anticipo: </strong>Se recibio anticipo por COP:<strong>$<?php echo number_format(($venta->anticipo),0,".",",");?></strong> pesos saldo por pagar en esta factura de:<strong>$<?php echo number_format(($venta->total_venta)-($venta->anticipo),0,".",",");?></strong> pesos iva incluido <p>{{$venta->condiciones}}</textarea></p>
        <?php
          }
          else
          {
            ?>
      <textarea id="descripccion">{{$venta->condiciones}}</textarea>
      <?php
          }
       ?>
</section>
    <footer>
      <img src="{{asset('imagenes/Footer.png')}}">
      <div id="textfooter">VHNGROUP: Tecnologia Automatizando su Hogar. - Documento creado en fisico y digital - Desarrollador VNOGUERA
      </div>
  </footer>
</body>
</html>