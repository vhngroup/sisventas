@extends('layouts.admin')  
@section('contenido')
<div class="row">
	<div class="col-lg-6 col-md-6 col-dm-12 col-xs-12">
	<h4>Nuevo Proyecto</h4>
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
		{!!Form::open(array('url'=>'proyectos','method'=>'POST','autocomplete'=>'off'))!!}
            {{Form::token()}}
<div class="row">	
		<div class="col-lg-4 col-md-6 col-dm-12 col-xs-12">
			<div class="form-group">
					  <label for="lblnombre">Cliente</label>
		             <select name="idpersona" id="idpersona" required class="form-control selectpicker" data-size="5" data-live-search="true">
		              @foreach($personas as $persona)
		              <option value="{{$persona->idpersona}}">{{$persona->nombre}}</option>
		              @endforeach
					</select>
				</div>
		</div>
		<div class="col-lg-3 col-md-3 col-dm-12 col-xs-12">
			<div class="form-group">
					<label for="lblf_comp">Fecha del Proyecto</label>
					<input type="date" name="fecha" value="<?php echo date("Y-m-d");?>" class="form-control">
			</div>
		</div>

		<div class="col-lg-2 col-md-3 col-dm-12 col-xs-12">
			<div class="form-group">
					<label for="lblnum_proyecto">Proyecto Numero:</label>
					<input type="text" name="num_proyecto" required readonly value= "{{$idproyecto}}" class="form-control">
			</div>
		</div>
		<div class="col-lg-3 col-md-4 col-dm-12 col-xs-12">
			<div class="form-group">
					<label for="lblestado">Estado</label>
					<select name="estado" id="idestado" class="form-control selectpicker" required data-size="5" data-live-search="true">
					@foreach($estado as $estados)
					<option value="{{$estados->idestado}}">{{$estados->estado}}</option>
					@endforeach
					</select>

			</div>
		</div>
		<div class="col-lg-12 col-md-12 col-dm-12 col-xs-12">
			<div class="form-group">
					  <label for="nombre">Alcance del Servicio</label>
		             <input type="text" name="descripcion" required id="descripcion" class="form-control" placeholder="Descripción">
			</div>
		</div>
		<div class="col-lg-12 col-md-12 col-dm-12 col-xs-12">
				<div class="form-group">
					<label for="condiciones">Notas e información del proyecto</label>
					<textarea type="text" name="observaciones" id="observaciones" class="form-control" placeholder="Usuarios, contraseñas, datos a recordar de la instalación, historia del proyecto"></textarea>
				</div>
			</div>
			<div class="col-lg-12 col-md-12 col-dm-12 col-xs-12">
							<label for="line">Recordatorios u advertencias del proyecto</label>
						</div>
	</div>

			<div class="row">
				<div class="panel panel-primary">
					<!-- <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button> -->
					<div class="panel-body">
						<div class="col-lg-10 col-md-10 col-dm-12 col-xs-12">
							<div class="form-group">
							<label for="lblalerta1">Descripción de la alerta</label>
							<input type="text" name="txtalerta1" id="alerta1" class="form-control" placeholder="Cantidad">
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-dm-12 col-xs-12">
							<div class="form-group">
								<label for="lblfalerta1">Fecha de alerta 1</label>
								<input type="date" name="datealerta1"  id="datealerta1" value="<?php echo date("Y-m-d");?>" placeholder="Y-m-d" pattern="\d{1,2}-\d{1,2}-\d{4}">
								
						    </div>
						</div>
						<div class="col-lg-10 col-md-10 col-dm-12 col-xs-12">
							<div class="form-group">
							<label for="lblalerta2">Descripción de la alerta</label>
							<input type="text" name="txtalerta2" id="alerta2" class="form-control" placeholder="Cantidad">
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-dm-12 col-xs-12">
							<div class="form-group">
								<label for="lblfalerta2">Fecha de alerta 2</label>
								<input type="date" name="datealerta2"  id="datealerta2" value="<?php echo date("Y-m-d");?>" placeholder="Y-m-d" pattern="\d{1,2}-\d{1,2}-\d{4}">
						    </div>
						</div>
					</div>
				</div>
			</div>
		<div class="col-lg-6 col-md-6 col-dm-6 col-xs-12" id="guardar">
				<div class="form-group">
					<input name="_token" value="{{ csrf_token() }}" type="hidden" type="submit"></input>
							<button class="btn btn-primary" id="guardar" onclick="evaluar()">Guardar</button>
							<button class="btn btn-danger" type="reset">Restablecer</button>
							<a class="btn btn-default" href="/sisventas/public/proyectos" role="button">Cancelar</a>
				</div>
		</div>
	</div>
		{!!Form::close()!!}  	
		 @push ('scripts')
		 <script>
		 let indice
			$(document).on('ready',function() 
			{
				$('select[name=estado]').val(2);
				$('select[name=idpersona]').val(1);
				$('selectpicker').selectpicker('refresh')
				 $('select.selectpicker').on('change', function(){
					indice = document.getElementById('idpersona')[document.getElementById('idpersona').options.selectedIndex].value
				});
				 state =1;
			});

		 	function evaluar()
				{
					state =0;
					 if(indice<=1)
						{	state =0;
							alert("Debe seleccionar un cliente")
							$("#guardar").hide();
						}
					else
						{
									state =1;
									agregar();
							
						}
				}
			
			window.addEventListener('beforeunload', function (e) {
			if (state ===1)
				{	

				}
					else
				{
					e.preventDefault();
	    			e.returnValue = '';
				}
			});

		 	
		 </script>
		@endpush
@endsection