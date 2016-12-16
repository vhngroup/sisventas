<!DOCTYPE html> 
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Propuesta de cotización # $cotizacion->idcotizacion</title>
    <link rel="stylesheet" href="css\style.css" media="all" />  
  </head>
  <body>
    <header class="clearfix">
      <div id="logo">
        <img src="imagenes\logo.png">
      </div>
      <div>
      <h1>Cotización # {{$cotizacion->num_comprobante}}{{$cotizacion->serie_comprobante}}-{{$cotizacion->idcotizacion}}</h1>
      <p> <b>Nombre del cliente:</b> {{$cotizacion->nombre}} <b>Identificación: </b> {{$cotizacion->tipo_documento}} - {{$cotizacion->num_documento}} <b>Telefono:</b> {{$cotizacion->telefono}}</p> 
      <p><b>Email:</b> {{$cotizacion->email}} <b>Dirección:</b> {{$cotizacion->direccion}}</p>
      <h4><b>Alcance:</b> {{$cotizacion->descripccion}}</h4>
      </div>
     </header>
<table>
   <thead>
       <tr>
            <th>Codigo</th>
            <th>Imagen</th>
            <th class="service">Descripcción</th>
            <th class="desc">Cantidad</th>
            <th>Precio</th>
            <th>TOTAL</th>
          </tr>
        </thead>
   <tbody>
@foreach($detalle as $det)
      <tr>
        <td class="service">{{$det->codigo}}</td>
        <td> <img src="imagenes\articulos\{{$det->imagen}}"> </td>
        <td class="service">{{$det->descripccion}}</td>
        <td class="unit">{{$det->precio_venta}}</td>
        <td class="qty">{{$det->cantidad}}</td>
        <td class="total">{{($det->cantidad*$det->precio_venta)}}</td>
      </tr>
         @endforeach
      <tr>
            <td colspan="5">Subtotal</td>
            <td class="total"> ${{$cotizacion->total_venta}}</td>
          </tr>
          <tr>
            <td colspan="5">Impuestos</td>
            <td class="total">$0</td>
          </tr>
          <tr>
            <td colspan="5" class="grand total">Valor Total</td>
            <td class="grand total">${{$cotizacion->total_venta}}</td>
      </tr>
     </tbody>
</table>
<div id="notices">
        <div>Condiciones del servicio:</div>
        <div><textarea cols="26" rows="8">{{$cotizacion->condiciones}}</textarea></div>
      </div>
    <footer>
      <div>VHNGROUP: Tecnologia Automatizando su Hogar. - Factura creada en fisico y digital por SisventasVHNGroup</div>
    <div id="footer">
        <img src="imagenes\footer.png">
      </div>
    </footer>
</body>
</html>



  

