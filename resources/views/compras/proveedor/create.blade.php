@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-6 col-md-6 col-dm-6 col-xs-12">
	<h3>Nuevo Proveedor</h3>
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
		{!!Form::open(array('url'=>'compras/proveedor','metodo'=>'POST','autocomplete'=>'off'))!!}
		{{Form::token()}}
<div class="row">	
<div class="col-lg-6 col-md-6 col-dm-6 col-xs-12">
	<div class="form-group">
			<label for="nombre">Nombre de la empresa</label>
			<input type="text" name="nombre" required value="{{old('nombre')}}" class="form-control" placeholder="Nombre...">
		</div>
</div>

<div class="col-lg-6 col-md-6 col-dm-6 col-xs-12">
	<div class="form-group">
			<label>Documentos</label>
			<select name="tipo_documento" class="form-control">
				<option value="Cc"> Cedula </option>
				<option value="NIT"> NIT </option>
				<option value="PASSP"> PAS </option>
				<option value="Registmerca"> Registro Mercantil </option>
			</select>
		</div>
</div>

<div class="col-lg-6 col-md-6 col-dm-6 col-xs-12">
	<div class="form-group">
			<label for="num_documento">Numero de documento</label>
			<input type="text" name="num_documento" value="{{old('num_documento')}}" class="form-control" placeholder="Numero de identificacion...">
		</div>
</div>

<div class="col-lg-6 col-md-6 col-dm-6 col-xs-12">
	<div class="form-group">
			<label for="nombrecontacto">Nombre del Asesor</label>
			<input type="text" name="nombrecontacto" value="{{old('nombrecontacto')}}" class="form-control" placeholder="nombre del contacto...">
		</div>
</div>
<div class="col-lg-6 col-md-6 col-dm-6 col-xs-12">
	<div class="form-group">
			<label for="telefono">Telefono</label>
			<input type="text" name="telefono" value="{{old('telefono')}}" class="form-control" placeholder="telefono...">
		</div>
</div>
<div class="col-lg-6 col-md-6 col-dm-6 col-xs-12">
	<div class="form-group">
			<label for="nombre">Dirección</label>
			<input type="text" name="direccion" value="{{old('direccion')}}" class="form-control" placeholder="Dirección...">
		</div>
</div>
<div class="col-lg-6 col-md-6 col-dm-6 col-xs-12">
	<div class="form-group">
			<label for="email">Email</label>
			<input type="email" name="email" value="{{old('email')}}" class="form-control" placeholder="email...">
		</div>
</div>
<div class="col-lg-6 col-md-6 col-dm-6 col-xs-12">
	<div class="form-group">
			<label for="notas">Notas</label>
			<input type="notas" name="email" value="{{old('notas')}}" class="form-control" placeholder="notas...">
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