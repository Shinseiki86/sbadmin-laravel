@extends('layouts.menu')
@section('title', '/ Tickets')

@section('page_heading')
	<div class="row">
		<div id="titulo" class="col-xs-8 col-md-6 col-lg-6">
			Tickets
		</div>
		<div id="btns-top" class="col-xs-4 col-md-6 col-lg-6 text-right">
			<a class='btn btn-primary' role='button' href="{{ route('cnfg-tickets.tickets.create') }}" data-tooltip="tooltip" title="Crear Nuevo">
				<i class="fa fa-plus" aria-hidden="true"></i>
			</a>
		</div>
	</div>
@endsection

@section('section')

	<table class="table table-striped" id="tabla">
		<thead>
			<tr>
				<th class="col-md-5"> Empleador </th>
				<th class="col-md-5"> Empleado </th>
				<th class="col-md-5"> Estado </th>
				<th class="col-md-5"> Tipo de Incidente </th>
				<th class="col-md-5"> Prioridad </th>
				<th class="col-md-5"> Categoria </th>
				<th class="col-md-1"> Fecha Evento </th>
				<th class="col-md-1"> Fecha Solicitud </th>
				<th class="col-md-1"> Fecha Cierre </th>
				<th class="col-md-1"> Estado Aprobación </th>
				<th class="col-md-1"> Grupo </th>
				<th class="col-md-1"> Turno </th>
				<th class="hidden-xs col-md-1">Creado</th>
				<th class="col-md-1 all"></th>
			</tr>
		</thead>
		<tbody></tbody>
	</table>

	@include('widgets/modal-delete')
	@include('datatable-ajax', ['urlAjax'=>'getTickets', 'columns'=>[
		'EMPL_NOMBRECOMERCIAL',
		'PROS_NOMBRESAPELLIDOS',
		'ESTI_DESCRIPCION',
		'TIIN_DESCRIPCION',
		'PRIO_DESCRIPCION',
		'CATE_DESCRIPCION',
		'TICK_FECHAEVENTO',
		'TICK_FECHASOLICITUD',
		'TICK_FECHACIERRE',
		'ESAP_DESCRIPCION',
		'GRUP_DESCRIPCION',
		'TURN_DESCRIPCION',
		'TICK_CREADOPOR',
	]])	
@endsection