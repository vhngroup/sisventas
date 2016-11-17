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
      <h1>Cotizacion # {{$cotizacion->num_comprobante}}{{$cotizacion->serie_comprobante}}-{{$cotizacion->idcotizacion}}</h1>
     </header>
    <main>  
<table>
   <thead>
       <tr>
            <th class="service">SERVICE</th>
            <th class="desc">DESCRIPTION</th>
            <th>PRICE</th>
            <th>QTY</th>
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
            <td colspan="5">SUBTOTAL</td>
            <td class="total">$5,200.00</td>
          </tr>
          <tr>
            <td colspan="5">Impuestos</td>
            <td class="total">$1,300.00</td>
          </tr>
          <tr>
            <td colspan="5" class="grand total">GRAND TOTAL</td>
            <td class="grand total">0</td>
      </tr>
     </tbody>
</table>
<div id="notices">
        <div>NOTICE:</div>
        <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
      </div>
    </main>
    <footer>
      Invoice was created on a computer and is valid without the signature and seal.
    </footer>
</body>
</html>



  

