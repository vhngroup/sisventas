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
      <h1>Factura # {{$venta->num_comprobante}}{{$venta->serie_comprobante}}-{{$venta->idventa}}</h1>
     </header>
    <main>  
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
        <div class="notice">{{$venta->condiciones}}</div>
      </div>
    </main>
    <footer>
      Invoice was created on a computer and is valid without the signature and seal.
      <br>
    <div id="footer">
        <img src="imagenes\footer.png">
      </div>
    </footer>
</body>
</html>

  

