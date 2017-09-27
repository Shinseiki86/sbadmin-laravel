@extends('layouts.menu')
@section('title', '/ Detalle Ticket')

@section('page_heading')
	<div class="row">
		<div id="titulo" class="col-xs-8 col-md-6 col-lg-6">
			Ticket No. {{ str_pad($ticket->TICK_ID, 6, '0', STR_PAD_LEFT) }}
		</div>
		<div id="btns-top" class="col-xs-4 col-md-6 col-lg-6 text-right">
			@rinclude('show-botones')
		</div>
	</div>
@endsection

@push('scripts')
	<script type="text/javascript">
		//===================================================================
		//se encarga de mostrar la imagen y/o archivo
		$("#imagenModal").on("click", function() {

			var tickarchivo =  "{{ $ticket->TICK_ARCHIVO }}";
			var src = "{{asset('storages/' . $ticket->TICK_ARCHIVO )}}";

			if(tickarchivo == "" || tickarchivo == null){
				src = "{{asset('storages/' . 'default.jpg' )}}";
				$('#imagepreview').attr('src', src );
				$('#imagemodal').modal('show');

				$('#btndescargar').hide();
				$('#psinarchivos').show();

			} else {

				var img = new Image();
				img.src = src;

				if(!img.complete){
					src = "{{asset('storages/' . 'filedefault.png' )}}";
					$('#imagepreview').attr('src', src);
					$('#imagemodal').modal('show'); 
				}else{
					src = "{{asset('storages/' . $ticket->TICK_ARCHIVO )}}";
					$('#imagepreview').attr('src', src); 
					$('#imagemodal').modal('show'); 
				}

				$('#pconarchivos').show();
			}
		});
		//===================================================================

		//===================================================================
		//modal para autorizar el ticket
		$("#autorizarModal").on("click", function() {
			$('#autorizarmodal').modal('show');
		});
		//===================================================================

		//===================================================================
		//modal para rechazar el ticket
		$("#rechazarModal").on("click", function() {
			$('#rechazarmodal').modal('show');
		});
		//===================================================================

		//===================================================================
		//modal para rechazar el ticket
		$("#cerrarModal").on("click", function() {
			$('#cerrarmodal').modal('show');
		});
		//===================================================================		
	</script>
@endpush


@section('section')

	@section ('generales_panel_title','Datos Generales')
	@section ('generales_panel_body')
		<ul class="list-group">
			@include('widgets.list-group-item', [
				'label'=>'Empleador',
				'value'=>$ticket->contrato->empleador->EMPL_RAZONSOCIAL
			])
			@include('widgets.list-group-item', [
				'label'=>'Fecha Creación',
				'value'=>$ticket->TICK_FECHASOLICITUD
			])
			@include('widgets.list-group-item', [
				'label'=>'Empleado',
				'value'=>nombre_empleado($ticket->contrato->PROS_ID)
			])
			@include('widgets.list-group-item', [
				'label'=>'Estado',
				'value'=>$ticket->estadoticket->ESTI_DESCRIPCION
			])
			@include('widgets.list-group-item', [
				'label'=>'Tipo de Incidente',
				'value'=>$ticket->tipoincidente->TIIN_DESCRIPCION
			])
			@include('widgets.list-group-item', [
				'label'=>'Prioridad',
				'value'=>$ticket->prioridad->PRIO_DESCRIPCION
			])
			@include('widgets.list-group-item', [
				'label'=>'Categoría',
				'value'=>$ticket->categoria->CATE_DESCRIPCION
			])
			@include('widgets.list-group-item', [
				'label'=>'Fecha del Evento',
				'value'=>$ticket->TICK_FECHAEVENTO
			])
			@include('widgets.list-group-item', [
				'label'=>'Observaciones',
				'value'=>$ticket->TICK_OBSERVACIONES
			])
			@include('widgets.list-group-item', [
				'label'=>'Estado Aprobación',
				'value'=>$ticket->estadoaprobacion->ESAP_DESCRIPCION
			])
		</ul>
	@endsection
	@include('widgets.panel', ['as'=>'generales', 'header'=>true])

	@section ('hechos_panel_title','Descripción de los Hechos')
	@section ('hechos_panel_body')
		{{ $ticket->TICK_DESCRIPCION }}
	@endsection
	@include('widgets.panel', ['as'=>'hechos', 'header'=>true])

	@section ('evidencias_panel_title','Evidencia')
	@section ('evidencias_panel_body')
		<div class="row">
			<div class="col-lg-4"><strong>Archivos:</strong></div>
			<div class="col-lg-8">
				<!-- Botón Ver (show) -->
				<a class="btn btn-small btn-basic btn-xs" href="#" data-tooltip="tooltip" title="Ver" id="imagenModal">
					<p hidden>
						@if ($ticket->TICK_ARCHIVO != NULL and $ticket->TICK_ARCHIVO != "")
						<img id="imageresource" src="{{asset('storages/' . $ticket->TICK_ARCHIVO)}}" style="width: 500px; height: 264px;">
						@else
						<img id="imageresource" src="{{asset('storages/' . 'filedefault.png' )}}" style="width: 500px; height: 264px;">
						@endif
					</p>
					<i class="fa fa-eye" aria-hidden="true"></i> Ver Archivo
				</a>
			</div>
		</div>
	@endsection
	@include('widgets.panel', ['as'=>'evidencias', 'header'=>true])

	{{-- @rinclude('show-botones') --}}
	@rinclude('show-modales')
@endsection
