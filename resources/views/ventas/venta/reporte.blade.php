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
          <img src="{{asset('imagenes/header.png')}}">
        </div>
        <div class="consignacion">
          <h1>Factura de Venta # <span>{{$venta->num_comprobante}}</span> del <?php $fecha_det= substr($venta->fecha_hora, -24,10); echo $fecha_det; ?></h1>
        </div>
        @if ($venta->num_comprobante >171)
          <div id="resolucion">Resolución de facturación {{$venta->resolucion_Facturacion}} del {{$venta->fecha_Inicio}} iniciando en {{$venta->resolucion_Desde}} y termina en {{$venta->resolucion_Hasta}} Habilitada por {{$venta->resolucion_meses}} meses hasta el dia {{$venta->fecha_Fin}}</div>
        @else
          <div id="resolucion">Resolución de facturación 18762006566971 del 2018-02-02 del 0001 al 1000 Habilitada por 18 meses hasta 02/08/2019</div>
        @endif
          <div id="alcance"><b>Alcance: </b>{{$venta->descripcion}}</div>
          <p id="DatosCliente">
              <span><b>Nombre del Cliente:</b> {{$venta->nombrecontacto}}  <b>Identificación:</b> {{$venta->tipo_documento}}:{{$venta->num_documento}}</span><br><span><b>Cliente:</b> {{$venta->nombre}} <b>Telefono:</b> {{$venta->telefono}} <b>Correo:</b> {{$venta->email}}</span><br><span> <b>Dirección:</b> {{$venta->direccion}}</span>
          </p>
        <div id="consignacion">
          <p> <span> Informaciòn de pago: </span> Consignaciòn Bancaria: Bancolombia, cuenta de ahorros # 122-978169-59 a nombre de Victor Noguera</p>
          <p> Regimen Comun, Nit: 1121859274-9 </p>
        </div>
      </div>
    </header>
<section>
  <table id="tablageneral">
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
              <td class="number">$ <?php echo number_format($det->total ,0,".",",");?></td>
            </tr>
      @endforeach
    </tbody>
  </table>
</section>
<br><table style='page-break-after:auto;'></br></table><br>  
<section>
  <div class="tablaresumen">
      <table id="tabletotal">
          <tbody>
            <?php
        if($venta->total_general >0)
          {
            ?>
              <tr>
              <td class="descripccioncentral"></td>
              <td class="descripccioncentral"></td>
              <td class="descripccioncentral"></td>
              <td class="descripccioncentral"></td>
              <td class="tituloresumen">Resumen Factura</td>
              <td class="descripccioncentral">Total General</td>
              <td class="descripccioncentral">$ <?php echo number_format($venta->total_general,0,".",",");?></td>td>
            </tr>
            @if  ($venta->total_descuento > 0)
            <tr>
              <td class="descripccioncentral"></td>
              <td class="descripccioncentral"></td>
              <td class="descripccioncentral"></td>
              <td class="descripccioncentral"></td>
              <td class="descripccioncentral"></td>
              <td class="descripccioncentral">Descuento</td>
              <td class="descripccioncentral">$ <?php echo number_format($venta->total_descuento,0,".",",");?></td>
            </tr>
            @endif
            <tr>
              <td class="descripccioncentral"></td>
              <td class="descripccioncentral"></td>
              <td class="descripccioncentral"></td>
              <td class="descripccioncentral"></td>
              <td class="descripccioncentral"></td>
              <td class="descripccioncentral">Subtotal</td>
              <td class="descripccioncentral">$ <?php echo number_format($venta->subtotal,0,".",",");?></td>
            </tr>
            <tr>
              <td class="descripccioncentral"></td>
              <td class="descripccioncentral"></td>
              <td class="descripccioncentral"></td>
              <td class="descripccioncentral"></td>
              <td class="descripccioncentral"></td>
              <td class="descripccioncentral"> Iva 19% </td>
              <td class="descripccioncentral">$ <?php echo number_format($venta->valoriva,0,".",",");?></td>
            </tr>
            <tr>
              <td class="descripccioncentral"></td>
              <td class="descripccioncentral"></td>
              <td class="descripccioncentral"></td>
              <td class="descripccioncentral"></td>
              <td class="descripccioncentral"></td>
              <td class="descripccioncentral">Valor Total a Pagar</td>
              <td class="descripccioncentral" id="ptotal">$ <?php echo number_format($venta->total_venta,0,".",",");?></td>
            </tr>
          <?php
              }
              else
              {
                ?>
              <tr>
              <td class="descripccioncentral"></td>
              <td class="descripccioncentral"></td>
              <td class="descripccioncentral"></td>
              <td class="descripccioncentral"></td>
              <td class="tituloresumen">Resumen Factura</td>
              <td class="descripccioncentral">Subtotal</td>
              <td class="descripccioncentral">$ <?php echo number_format(($venta->descuento+$venta->total_venta)/1.19,0,".",",");?></td>
            </tr>
            <tr>
              <td class="descripccioncentral"></td>
              <td class="descripccioncentral"></td>
              <td class="descripccioncentral"></td>
              <td class="descripccioncentral"></td>
              <td class="descripccioncentral"></td>
              <td class="descripccioncentral">Descuento</td>
              <td class="descripccioncentral">$ <?php echo number_format($venta->descuento,0,".",",");?></td>
            </tr>
            <tr>
              <td class="descripccioncentral"></td>
              <td class="descripccioncentral"></td>
              <td class="descripccioncentral"></td>
              <td class="descripccioncentral"></td>
              <td class="descripccioncentral"></td>
              <td class="descripccioncentral">Iva 19%</td>
              <td class="descripccioncentral">$ <?php echo number_format( ($venta->total_venta/1.19) * 0.19,0,".",",");?></td>
            </tr>
            <tr>
              <td class="descripccioncentral"></td>
              <td class="descripccioncentral"></td>
              <td class="descripccioncentral"></td>
              <td class="descripccioncentral"></td>
              <td class="descripccioncentral"></td>
              <td class="descripccioncentral">Valor Total</td>
              <td class="descripccioncentral" id="ptotal">$ <?php echo number_format($venta->total_venta,0,".",",");?></td>
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
          <?php
              if($venta->anticipo > 0)
              {
          ?>
          <textarea id="observaciones"><strong>Anticipo: </strong>Se recibio anticipo por COP:<strong>$<?php echo number_format(($venta->anticipo),0,".",",");?></strong> pesos saldo por pagar en esta factura de:<strong>$<?php echo number_format(($venta->total_venta)-($venta->anticipo),0,".",",");?></strong> pesos iva incluido <p>{{$venta->condiciones}}</textarea></p>
          <?php
            }
            else
            {
          ?>
        <textarea id="observaciones">{{$venta->condiciones}}</textarea>
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