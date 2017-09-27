<!-- Creates the bootstrap modal where the image will appear -->
<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Evidencia</h4>
			</div>
			<div class="modal-body">
				<img src="" id="imagepreview" style="width: 400px; height: 264px;" >
			</div>
			<div>
				<p hidden id="psinarchivos" class="text-center">
					<b>No hay archivos disponibles</b>
				</p>

				<p hidden id="pconarchivos" class="text-center">
					<b>Hay archivos disponibles, para ver haga click en descargar</b>
				</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">
					<span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Salir
				</button>

				<a href="{{asset('storages/' . $ticket -> TICK_ARCHIVO)}}" class="btn btn-info" role="button" id="btndescargar" download>
					<span class="glyphicon glyphicon-save" aria-hidden="true"></span>Descargar
				</a>
				
			</div>
		</div>
	</div>
</div>

<!-- Creates the bootstrap modal where the image will appear -->
<div class="modal fade" id="autorizarmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Confirmación</h4>
			</div>
			
			<div>
				<p class="text-center">
					<b>¿Autorizar el Ticket?</b>
				</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">
					<span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Salir
				</button>

				<a href="{{ URL::to('cnfg-tickets/tickets/autorizar/' . $ticket -> TICK_ID ) }}" class="btn btn-success" role="button" id="btnautorizar">
					<span class="fa fa-check" aria-hidden="true"></span> SI
				</a>
				
			</div>
		</div>
	</div>
</div>

<!-- Creates the bootstrap modal where the image will appear -->
<div class="modal fade" id="rechazarmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Confirmación</h4>
			</div>
			
			<div>
			{{ Form::open( ['url' => 'cnfg-tickets/tickets/rechazar/' . $ticket -> TICK_ID , 'id'=>'frmRechazarTicket', 'class' => 'form-vertical'] ) }}

				{{ Form::label('TICK_MOTIVORECHAZO', 'Motivo de Rechazo:') }}

						{{ Form::textarea('TICK_MOTIVORECHAZO', old('TICK_MOTIVORECHAZO'), [
							'class' => 'form-control',
							'size' => '20x3',
							'placeholder' => 'Escriba aquí...',
							'style' => 'resize: vertical',
							'required'
						]) }}

			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">
					<span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Salir
				</button>

				{{ Form::button('<i class="fa fa-times-circle" aria-hidden="true"></i> Rechazar',[
						'name'=>'btn-confirmClose',
						'class'=>'btn btn-success',
						'id'=>'submit',
						'type'=>'submit',
					]) }}

				{{ Form::close() }}
				
			</div>
		</div>
	</div>
</div>

<!-- Creates the bootstrap modal where the image will appear -->
<div class="modal fade" id="cerrarmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Confirmación</h4>
			</div>
			
			<div>
				<p class="text-center">
					<b>Detalles del Cierre</b>
				</p>

				<p class="text-center">
					{{ Form::open( ['url' => 'cnfg-tickets/tickets/cerrar/' . $ticket -> TICK_ID , 'id'=>'frmCerrarTicket', 'class' => 'form-vertical'] ) }}

					<div class="form-group{{ $errors->has('SANC_ID') ? ' has-error' : '' }}">
						<label for="SANC_ID" class="col-md-4 control-label">Decisión Administrativa</label>
						<div class="col-md-6">
							{{ Form::select('SANC_ID', [null => 'Seleccione una opción'] + $arrSanciones , old('SANC_ID'), [
							'class' => 'form-control',
							'required'
							]) }}

							@if ($errors->has('SANC_ID'))
							<span class="help-block">
								<strong>{{ $errors->first('SANC_ID') }}</strong>
							</span>
							@endif
						</div>
					</div>

						{{ Form::label('TICK_CONCLUSION', 'Observaciones:') }}
						{{ Form::textarea('TICK_CONCLUSION', old('TICK_CONCLUSION'), [
							'class' => 'form-control',
							'size' => '20x3',
							'placeholder' => 'Escriba aquí...',
							'style' => 'resize: vertical',
							'required'
						]) }}
				</p>
			</div>

			<div class="modal-footer">

				<button type="button" class="btn btn-danger" data-dismiss="modal">
					<span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Salir
				</button>

				{{ Form::button('<i class="fa fa-check" aria-hidden="true"></i> Cerrar',[
						'name'=>'btn-confirmClose',
						'class'=>'btn btn-success',
						'id'=>'submit',
						'type'=>'submit',
					]) }}
				{{ Form::close() }}

			</div>
		</div>
	</div>
</div>
