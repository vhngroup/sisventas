@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-4 col-md-6 col-dm-6 col-xs-12">
	<h3>Nuevo Cliente</h3>
	@if(count($errors)>0)
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors-> all() as $error)
					<li>
					{{$error}}
					</li>
				@endforeach
			</ul>
		</div>
		@endif
	</div>
</div>
		{!!Form::open(array('url'=>'ventas/cliente','metodo'=>'POST','autocomplete'=>'off'))!!}
		{{Form::token()}}
<div class="row">	
<div class="col-lg-4 col-md-6 col-dm-6 col-xs-12">
	<div class="form-group">
			<label for="nombre">Empresa</label>
			<input type="text" name="nombre" required value="{{old('nombre')}}" class="form-control" placeholder="Nombre...">
		</div> 	
</div>

<div class="col-lg-4 col-md-6 col-dm-6 col-xs-12">
	<div class="form-group">
			<label>Tipo de documento</label>
			<select name="tipo_documento" class="form-control">
				<option value="Cc"> Cedula </option>
				<option value="NIT"> NIT </option>
				<option value="PAS"> PAS </option>
				<option value="Regmerc"> Registro Mercantil </option>
			</select>
		</div>
</div>

<div class="col-lg-4 col-md-6 col-dm-6 col-xs-12">
	<div class="form-group">
			<label for="num_documento">Numero de documento</label>
			<input type="text" name="num_documento" value="{{old('num_documento')}}" class="form-control" placeholder="Numero de identificacion...">
		</div>
</div>

<div class="col-lg-4 col-md-6 col-dm-6 col-xs-12">
	<div class="form-group">
			<label for="nombrecontacto">Persona de Contacto</label>
			<input type="text" name="nombrecontacto" required value="{{old('nombrecontacto')}}" class="form-control" placeholder="Nombre...">
		</div>
</div>
<div class="col-lg-4 col-md-6 col-dm-6 col-xs-12">
	<div class="form-group">
			<label for="telefono">Telefono</label>
			<input type="text" name="telefono" value="{{old('telefono')}}" class="form-control" placeholder="telefono...">
		</div>
</div>
<div class="col-lg-4 col-md-6 col-dm-6 col-xs-12">
	<div class="form-group">
			<label for="nombre">Dirección</label>
			<input type="text" name="direccion" value="{{old('direccion')}}" class="form-control" placeholder="Dirección...">
		</div>
</div>

<div class="col-lg-3 col-md-6 col-dm-6 col-xs-12">
	<div class="form-group">
			<label for="email">Email</label>
			<input type="email" name="email" value="{{old('email')}}" class="form-control" placeholder="email...">
		</div>
</div>
<div class="col-lg-3 col-md-6 col-dm-6 col-xs-12">
	<div class="form-group">
			<label>Tipo de cuenta</label>
			<select name="tipocuenta" class="form-control">
				<option value="">Seleccione Opcción </option>
				<option value="Ahorros"> Ahorros </option>
				<option value="Corriente"> Corriente </option>
			</select>
		</div>
</div>

<div class="col-lg-3 col-md-6 col-dm-6 col-xs-12">
	<div class="form-group">
			<label for="Banco">Banco</label>
			<input type="text" name="banco" value="{{old('banco')}}" class="form-control" placeholder="banco">
		</div>
</div>
<div class="col-lg-3 col-md-6 col-dm-6 col-xs-12">
	<div class="form-group">
			<label for="numerodecuenta">Numero de cuenta</label>
			<input type="number" name="numerodecuenta" value="{{old('numerodecuenta')}}" class="form-control" placeholder="numero de cuenta">
		</div>
</div>
<div class="col-lg-12 col-md-12 col-dm-12 col-xs-12">
	<div class="form-group">
			<label for="notas">Datos relevantes del ciente</label>
			<input type="notas" name="notas" value="{{old('notas')}}" class="form-control" placeholder="Apuntes">
		</div>
</div>

<div class="col-lg-6 col-md-6 col-dm-6 col-xs-12">
	<div class="form-group">
			<button class="btn btn-primary" type="submit">Guardar</button>
			<button class="btn btn-danger" type="reset">Cancelar</button>
	</div>
</div>
</div>
{!!Form::close()!!}
@endsection