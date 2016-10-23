@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-6 col-md-6 col-dm-6 col-xs-12">
	<h3>Editar Articulo: {{$articulo->Nombre}}</h3>
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
{!! Form::model($articulo,['method'=>'PATCH','route'=>['articulo.update',$articulo->idArticulo],'files'=>'true']) !!}
{{Form::token()}}
<div class="row">	
<div class="col-lg-6 col-md-6 col-dm-6 col-xs-12">
	<div class="form-group">
			<label for="nombre">Nombre</label>
			<input type="text" name="nombre" required value="{{$articulo->nombre}}" class="form-control">
	</div>
</div>
<div class="col-lg-6 col-md-6 col-dm-6 col-xs-12">
	<div class="form-group">
			<label>Categoria</label>
			<select name="idCategoria" class="form-control">
			@foreach($categoria as $cat)
				@if ($cat->idCategoria==$articulo->idCategoria)
				<option value="{{$cat->idCategoria}}"selected> {{$cat->Nombre}} </option>
				@else
				<option value="{{$cat->idCategoria}}"> {{$cat->Nombre}} </option>
				@endif
			@endforeach
			</select>
		</div>
</div>
<div class="col-lg-6 col-md-6 col-dm-6 col-xs-12">
	<div class="form-group">
			<label for="codigo">codigo</label>
			<input type="text" name="codigo" required value="{{$articulo->codigo}}" class="form-control">
	</div>
</div>

<div class="col-lg-6 col-md-6 col-dm-6 col-xs-12">
	<div class="form-group">
			<label for="stock">Stock</label>
			<input type="text" name="stock" required value="{{$articulo->stock}}" class="form-control">
		</div>
</div>
<div class="col-lg-6 col-md-6 col-dm-6 col-xs-12">
	<div class="form-group">
			<label for="descripccion">Descripcción</label>
			<input type="text" name="descripccion" value="{{$articulo->descripccion}}" class="form-control" placeholder="Descripccion del articulo">
		</div>
</div>
<div class="col-lg-6 col-md-6 col-dm-6 col-xs-12">
	<div class="form-group">
			<label for="imagen">Imagen</label>
			<input type="file" name="imagen"  class="form-control">
			@if(($articulo->imagen)!="")
			<img src="{{asset('/imagenes/articulos/'.$articulo->imagen)}}" height="300px" width="300px" >
			@endif
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