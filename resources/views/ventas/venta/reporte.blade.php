<!DOCTYPE html>
<html lang="es">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Factura de Venta # {{$venta->idventa}}</title>
    <link rel="stylesheet" href="css\style.css" media="all" />
   </head>
  <body>
    <header class="clearfix">
      <div id="logo">
        <img src="imagenes\logo.png">
      </div>
      <div>
      <h1>Factura de Venta # {{$venta->num_comprobante}}{{$venta->serie_comprobante}}-{{$venta->idventa}}</h1>
      <div id="pago">
      <p><h3>Informaciòn de pago: Consignaciòn Bancaria: Bancolombia, cuenta de ahorros # 122-978169-59 a nombre de Victor Hugo Noguera</h3>
      <h3>Regimen simplificado a Nombre de Victor Hugo Noguera Lievano Nit: 1121859274-9</h3></p>
      </div>
      <div id="alcance"><b>Alcance: </b>{{$venta->descripccion}}
      </div>
        <div id="DatosCliente">
        <p><b>Cliente:</b> {{$venta->nombre}} <b>Identificación:</b> {{$venta->tipo_documento}} <b>Numero:</b> {{$venta->num_documento}} <b>Nombre del Cliente:</b> {{$venta->nombrecontacto}}</p>
            <p><b>Telefono:</b> {{$venta->telefono}} <b>Correo:</b> {{$venta->email}} <b>Dirección:</b>
        {{$venta->direccion}}</p>
      </div>
     </header>
<table>
   <thead>
       <tr>
            <th>Codigo</th>
            <th>Imagen</th>
            <th>Descripcción</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Total</th>
          </tr>
        </thead>
   <tbody>
@foreach($detalle as $det)
      <tr>
        <td class="item">{{$det->codigo}}</td>
        <td> <img src="imagenes\articulos\{{$det->imagen}}"> </td>
        <td class="item">{{$det->descripccion}}</td>
        <td class="number">{{$det->cantidad}}</td>
        <td class="item"><output>{{$det->precio_venta}}</output></td>
        <td class="item"><output>{{($det->cantidad*$det->precio_venta)}}</output></td>
      </tr>
         @endforeach
     </tbody>
</table>    
    <footer>
    <table> 
    <thead>
       <tr>
            <th>---------------------------------</th>
            <th>-------------------------------------------------------</th>
            <th>-----------------------------------------------------</th>
            <th>----------------------------------------------------</th>
            <th>---------------------------------------------------</th>
            <th>---------------------------------------------------</th>
          </tr>
        </thead>
   
        <tbody>
            <tr>
            <td colspan="6" class="descripccion"> Subtotal </td>
            <td class="descripccion">${{$venta->total_venta}}</td>
          </tr>
          <tr>
            <td colspan="6" class="descripccion">Impuestos</td>
            <td class="descripccion">$0</td>
          </tr>
          <tr>
            <td colspan="6" class="descripccion">Descuento</td>
            <td class="descripccion">$0</td>
          </tr>
          <tr>
            <td colspan="6" class="descripccion">Anticipo</td>
            <td class="descripccion">${{$venta->anticipo}}</td>
          </tr>s
          <tr>
            <td colspan="6" class="descripccion">Valor Total</td>
            <td class="descripccion" id="ptotal">{{$venta->total_venta}}</td>
          </tr>
          </tbody>
    </table>
      <div>Condiciones del servicio:</div>
      <textarea cols="30" rows="5" id="comment">{{$venta->condiciones}}</textarea>
      <div>VHNGROUP: Tecnologia Automatizando su Hogar. - Factura creada en fisico y digital por SisventasVHNGroup
      <figure id="imagenfooter"> 
            <img src="imagenes\footer.png">
      </figure>
      </div>
    </footer>
</body>
</html>