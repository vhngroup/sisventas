@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-6 col-md-6 col-dm-6 col-xs-12">
	<h3>Editar Categoria: {{$categoria->Nombre}}</h3>
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
		{!! Form::model($categoria,['method'=>'PATCH','route'=>['categoria.update',$categoria->idCategoria]]) !!}
		{{Form::token()}}
		<div class="form-group">
			<label for="Nombre">Nombre</label>
			<input type="text" name="nombre" class="form-control" value="{{$categoria->Nombre}}" placeholder="Nombre...">
		</div>
		<div class="form-group">
			<label for="Descripccion">Descripccion</label>
			<input type="text" name="descripccion" class="form-control"  value="{{$categoria->Descripccion}}" placeholder="Descripccion...">
		</div>
		<div class="form-group">
			<button class="btn btn-primary" type="submit">Guardar</button>
			<button class="btn btn-danger" type="reset">Cancelar</button>
		</div>
		{!!Form::close()!!}
	</div>
</div>
@endsection