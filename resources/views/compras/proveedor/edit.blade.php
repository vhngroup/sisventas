@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-6 col-md-6 col-dm-6 col-xs-12">
	<h3>Editar Proveedor: {{$persona->nombre}}</h3>
	@if(count($errors)>0)
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
					<li>
					{{$error}}
					</li>
				@endforeach
			</ul>
		</div>
		@endif
		</div>
</div>
{!! Form::model($persona,['method'=>'PATCH','route'=>['proveedor.update',$persona->idpersona]]) !!}
{{Form::token()}}
<div class="row">	
<div class="col-lg-4 col-md-6 col-dm-6 col-xs-12">
	<div class="form-group">
			<label for="nombre">Empresa</label>
			<input type="text" name="nombre" value="{{$persona->nombre}}" class="form-control" placeholder="Nombre...">
		</div>
</div>

<div class="col-lg-4 col-md-6 col-dm-6 col-xs-12">
	<div class="form-group">
			<label>Documentos</label>
			<select name="tipo_documento" class="form-control">
			@if($persona->tipo_documento=='Cc')
				<option value="NIT"> NIT </option>
				<option value="Registro Mercantil"> Registro Mercantil </option>
			@elseif($persona->tipo_documento=='NIT')
			   <option value="Cc"> Cedula </option>
				<option value="NIT" selected> NIT </option>
				<option value="Registro Mercantil"> Registro Mercantil </option>
				@else($persona->tipo_documento=='Registro Mercantil')
			   <option value="Cc"> Cedula </option>
				<option value="NIT"> NIT </option>
				<option value="Registmerca" selected> Registro Mercantil </option>
			@endif
			</select>
		</div>
</div>

<div class="col-lg-4 col-md-6 col-dm-6 col-xs-12">
	<div class="form-group">
			<label for="num_documento">Numero de documento</label>
			<input type="text" name="num_documento" value="{{$persona->num_documento}}" class="form-control" placeholder="Numero de identificacion...">
		</div>
</div>


<div class="col-lg-4 col-md-6 col-dm-6 col-xs-12">
	<div class="form-group">
			<label for="nombrecontacto">Representante</label>
			<input type="text" name="nombrecontacto" value="{{$persona->nombrecontacto}}" class="form-control" placeholder="Representante">
		</div>
</div>
<div class="col-lg-4 col-md-6 col-dm-6 col-xs-12">
	<div class="form-group">
			<label for="telefono">Telefono</label>
			<input type="text" name="telefono" value="{{$persona->telefono}}" class="form-control" placeholder="telefono...">
		</div>
</div>
<div class="col-lg-4 col-md-6 col-dm-6 col-xs-12">
	<div class="form-group">
			<label for="email">Email</label>
			<input type="email" name="email" value="{{$persona->email}}" class="form-control" placeholder="email...">
		</div>
</div>

<div class="col-lg-4 col-md-6 col-dm-6 col-xs-12">
	<div class="form-group">
			<label for="nombre">Dirección</label>
			<input type="text" name="direccion" value="{{$persona->direccion}}" class="form-control" placeholder="Dirección...">
		</div>
</div>
<div class="col-lg-4 col-md-6 col-dm-6 col-xs-12">
	<div class="form-group">
			<label>Tipo de cuenta</label>
			<select name="tipocuenta" class="form-control">
				<option value="">Seleccione Opcción </option>
				<option value="Ahorros"> Ahorros </option>
				<option value="Corriente"> Corriente </option>
			</select>
		</div>
</div>

<div class="col-lg-4 col-md-6 col-dm-6 col-xs-12">
	<div class="form-group">
			<label for="Banco">Banco</label>
			<input type="text" name="banco" value="{{$persona->banco}}" class="form-control" placeholder="banco">
		</div>
</div>
<div class="col-lg-4 col-md-6 col-dm-6 col-xs-12">
	<div class="form-group">
			<label for="numerodecuenta">Numero de cuenta</label>
			<input type="number" name="numerodecuenta" value="{{$persona->numerodecuenta}}" class="form-control" placeholder="numero de cuenta">
		</div>
</div>
<div class="col-lg-12 col-md-12 col-dm-12 col-xs-12">
	<div class="form-group">
			<label for="notas">Notas</label>
			<input type="notas" name="notas" value="{{$persona->Notas}}" class="form-control" placeholder="Notas...">
		</div>
</div>


<div class="col-lg-6 col-md-6 col-dm-6 col-xs-12">
	<div class="form-group">
			<button class="btn btn-primary" type="submit">Guardar</button>
			<button class="btn btn-danger" type="reset">Restablecer</button>
			<a class="btn btn-primary" href="/compras/proveedor" role="button">Cancelar</a>
</form>
	</div>
</div>
</div>
{!!Form::close()!!}
@endsection