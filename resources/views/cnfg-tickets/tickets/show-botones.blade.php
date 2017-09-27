<?php
	use \App\Models\EstadoAprobacion
?>
<!-- Botones -->
<div class="form-group">
	<div class="col-md-6 col-md-offset-4 text-right">

		{{-- ===================================================================
		si el estado de aprobación es diferente del inicial cuando se crea el ticket
		se esconden los botones --}}
		@if($ticket->ESAP_ID == EstadoAprobacion::REVISION)
			<a href="#" class="btn btn-success" role="button" id="autorizarModal">
				<span class="fa fa-check" aria-hidden="true"></span> Autorizar
			</a>
			<a href="#" class="btn btn-danger" role="button" id="rechazarModal">
				<span class="fa fa-close" aria-hidden="true"></span> Rechazar
			</a>
		@endif
		@if($ticket->ESAP_ID == EstadoAprobacion::ENVIADO)
			<a href="#" class="btn btn-success" role="button" id="cerrarModal">
				<span class="fa fa-check" aria-hidden="true"></span> Cerrar Ticket
			</a>
		@endif

		<a class="btn btn-warning" role="button" href="{{ URL::to('cnfg-tickets/tickets/') }}" data-tooltip="tooltip" title="Regresar">
			<i class="fa fa-arrow-left" aria-hidden="true"></i>
		</a>
	</div>
</div>
