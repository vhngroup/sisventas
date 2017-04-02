<!DOCTYPE html> 
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Propuesta de cotización # {{$cotizacion->idcotizacion}}</title>
    <link rel="stylesheet" href="css\style.css" media="all" />
  </head>
  <body>
    <header class="clearfix">
      <div id="logo">
        <img src="imagenes\logo.png">
      </div>
      <div>
      <h1>Cotización # {{$cotizacion->num_comprobante}}{{$cotizacion->serie_comprobante}}-{{$cotizacion->idcotizacion}}</h1>
       <div id="logo">Alcance: {{$cotizacion->descripccion}}</div>
      <table>
        <tr>
        <th class="cliente"></th>
        <th class="cliente"></th>
        <th class="cliente"></th>
        </tr>
        <tr>
          <td class="cliente">{{$cotizacion->nombre}}</td>
          <td class="cliente">{{$cotizacion->tipo_documento}} {{$cotizacion->num_documento}} </td>
          <td class="cliente">{{$cotizacion->telefono}}</td>
        </tr>
        <tr>
          <td class="cliente">{{$cotizacion->nombrecontacto}}</td>
          <td class="cliente">{{$cotizacion->email}}</td>
          <td class="cliente">{{$cotizacion->direccion}}</td>
        </tr>
      </table>
      </div>
     </header>
<table>
   <thead>
       <tr>
            <th class="unit">Codigo</th>
            <th class="unit">Imagen</th>
            <th class="unit">Descripcción</th>
            <th class="unit">Cantidad</th>
            <th class="unit">Precio</th>
            <th class="unit">Total</th>
          </tr>
        </thead>
   <tbody>
@foreach($detalle as $det)
      <tr>
        <td class="service">{{$det->codigo}}</td>
        <td> <img src="imagenes\articulos\{{$det->imagen}}"> </td>
        <td class="service">{{$det->descripccion}}</td>
        <td class="qty">{{$det->cantidad}}</td>
        <td class="unit">{{$det->precio_venta}}</td>
        <td class="total">{{($det->cantidad*$det->precio_venta)}}</td>
      </tr>
         @endforeach
            <tr>
              <td colspan="6" class="grand"></td>
            </tr>
            <tr>
            <td colspan="5" class="descripccion">Subtotal</td>
            <td class="descripccion">${{$cotizacion->total_venta}}</td>
          </tr>
          <tr>
            <td colspan="5" class="descripccion">Impuestos</td>
            <td class="descripccion">$0</td>
          </tr>
          <tr>
            <td colspan="5" class="descripccion">Valor Total</td>
            <td class="descripccion">${{$cotizacion->total_venta}}</td>
      </tr>
     </tbody>
</table>
<div id="notices">
        <div>Condiciones del servicio:</div>
        <div><textarea cols="26" rows="8" >{{$cotizacion->condiciones}}</textarea></div> 
      </div>
    <footer>
      <div>VHNGROUP: Tecnologia Automatizando su Hogar. - Factura creada en fisico y digital por SisventasVHNGroup</div>
    <div id="footer">
        <img src="imagenes\footer.png">
      </div>
    </footer>
</body>
</html>



  

