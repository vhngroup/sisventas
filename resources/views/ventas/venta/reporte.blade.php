<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Factura de Venta # {{$venta->idventa}}</title>
    <link rel="stylesheet" href="css\style.css" media="all" />  
  </head>
  <body>
    <header class="clearfix">
      <div id="logo">
        <img src="imagenes\logo.png">
      </div>
      <div>
      <h1>Factura # {{$venta->num_comprobante}}{{$venta->serie_comprobante}}-{{$venta->idventa}}</h1>
      <p> <b>Nombre del cliente:</b> {{$venta->nombre}} <b>Identificación: </b> {{$venta->tipo_documento}} - {{$venta->num_documento}} <b>Telefono:</b> {{$venta->telefono}}</p> 
      <p><b>Email:</b> {{$venta->email}} <b>Dirección:</b> {{$venta->direccion}}</p>
      <h4><b>Alcance:</b> {{$venta->descripccion}}</h4>
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
        <td class="unit">{{$det->cantidad}}</td>
        <td class="qty">{{$det->precio_venta}}</td>
        <td class="qty">{{($det->cantidad*$det->precio_venta)}}</td>
      </tr>
         @endforeach
      <tr>
            <td colspan="5">Subtotal</td>
            <td class="total"> ${{$venta->total_venta}}</td>
          </tr>
          <tr>
            <td colspan="5">Impuestos</td>
            <td class="total">$0</td>
          </tr>
          <tr>
            <td colspan="5" class="grand total">Valor Total</td>
            <td class="grand total">${{$venta->total_venta}}</td>
      </tr>
     </tbody>
</table>
<div id="notices">
        <div>Condiciones del servicio:</div>
        <div><textarea cols="26" rows="8">{{$venta->condiciones}}</textarea></div>
      </div>
    
    <footer>
      <div>VHNGROUP: Tecnologia Automatizando su Hogar. - Factura creada en fisico y digital por SisventasVHNGroup</div>
    <div id="footer">
        <img src="imagenes\footer.png">
      </div>
    </footer>
</body>
</html>

  

