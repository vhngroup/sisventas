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
{!! Form::model($articulo,['method'=>'PATCH','route'=>['articulo.update',$articulo->idarticulo],'files'=>'true']) !!}
{{Form::token()}}

<?php 
echo Form::open(['url'=>'articulo.update']);
 ?>
<input type="hidden" name="_token" value="{{ csrf_token() }}">
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
			<select name="idcategoria" class="form-control">
			@foreach($categoria as $cat)
				@if ($cat->idcategoria==$articulo->idcategoria)
				<option value="{{$cat->idcategoria}}"selected> {{$cat->Nombre}} </option>
				@else
				<option value="{{$cat->idcategoria}}"> {{$cat->Nombre}} </option>
				@endif
			@endforeach
			</select>
		</div>
</div>
<div class="col-lg-4 col-md-4 col-dm-4 col-xs-12">
	<div class="form-group">
			<label for="codigo">codigo</label>
			<input type="text" name="codigo" value="{{$articulo->codigo}}" class="form-control">
	</div>
</div>

<div class="col-lg-4 col-md-4 col-dm-4 col-xs-12">
	<div class="form-group"> 
			<label for="stock">Stock</label>
			<input type="text" name="stock" required value="{{$articulo->stock}}" class="form-control">
		</div>
</div>
<div class="col-lg-4 col-md-4 col-dm-4 col-xs-12">
	<div class="form-group">
			<label for="impuesto">impuesto</label>
			<select name="impuesto" id="impuesto" selected="{{$articulo->impuesto}}" class="form-control">
			@foreach($impuestos as $impuesto)
			<option value="{{$articulo->impuesto}}">{{$impuesto->porcentaje}}</option>
			@endforeach
			</select>
		</div>
</div>
<div class="col-lg-12 col-md-12 col-dm-12 col-xs-12">
	<div class="form-group">
			<label for="descripccion">Descripcción</label>
			<textarea type="text" id="descripccion" name="descripccion" class="form-control" placeholder="Descripccion del articulo" rows="2">{{$articulo->descripccion}}</textarea>
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