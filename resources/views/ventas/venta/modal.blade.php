<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-delete-{{$ven->idventa}}" >
{{Form::Open(array('action'=>array('VentaController@destroy',$ven->idventa),'method'=>'delete'))}}
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal aria-label="close">
				<span aria-hidden="true">x</span>
			</button>
			<h4 class="modal-title">Cancelar Venta</h4>
		</div>
		<div class="modal-body">
			<p>Corfirme si desea cancelar la venta {{$ven->idventa}}</p>
		</div>
		<div class="row">
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary">Confirmar</button>
		</div>
	</div>
</div>

{{Form::Close()}}
	
</div>
