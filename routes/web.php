<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});

Route::resource('almacen/categoria','CategoriaController');
Route::resource('almacen/articulo','ArticuloController');
Route::resource('proyectos','ProyectoController');
Route::resource('ventas/cliente','ClienteController');
Route::resource('ventas/venta','VentaController');
Route::resource('banco','CuentaController');
Route::resource('compras/proveedor','ProveedorController');
Route::resource('compras/ingreso','IngresoController');
Route::resource('seguridad/usuario','UsuarioController');
Route::resource('cotizaciones','CotizacionController');
Route::resource('pedidos','PedidoController');
Route::resource('/pdf','PdfController'); 
Route::get('crear_reporte_porventa/{tipo}','PdfController@crear_reporte_porventa'); 
Route::get('/cotizacion/reporte/{id}', 'CotizacionController@crear_pdf');
Route::get('/ventas/venta/reporte/{id}', 'VentaController@crear_pdf');
Route::get('/pedidos/reporte/{id}', 'PedidoController@crear_pdf');
Route::get('/logout', 'Auth\LoginController@logout');

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/{slug?}', 'HomeController@index');