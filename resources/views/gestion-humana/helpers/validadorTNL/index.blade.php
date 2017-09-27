@extends('layouts.menu')
@section('title', '/ TNL - Incapacidades')
@include('datatable')

@section('page_heading')
	<div class="row">
		<div id="titulo" class="col-xs-8 col-md-6 col-lg-6">
			TNL - Incapacidades
		</div>

		<div id="btns-top" class="col-xs-4 col-md-6 col-lg-6 text-right">
			<a class='btn btn-primary' role='button' href="{{ route('tnl.create') }}" data-tooltip="tooltip" title="Nueva Validación">
				<i class="fa fa-plus" aria-hidden="true"></i>
			</a>
		</div>


	</div>
@endsection

@section('section')

	<table class="table table-striped" id="tabla">
		<thead>
			<tr>
				<th class="hidden-xs col-md-1">Empresa</th>
				<th class="col-md-1">Identificación</th>
				<th class="col-md-5">Nombre</th>
				<th class="col-md-5">Fecha ini</th>
				<th class="col-md-5">Días</th>
				<th class="col-md-5">Fecha fin</th>
				<th class="col-md-5">Conting.</th>
				<th class="col-md-5">Primer día at</th>
				<th class="col-md-1">Documento</th>
				<th class="col-md-1 all"></th>
			</tr>
		</thead>

		<tbody>
			@foreach($incaps as $incap)
			<tr>
				<td>{{ $incap -> INCA_EMPRESA }}</td>
				<td>{{ $incap -> INCA_IDENTIFICACION }}</td>
				<td>{{ $incap -> INCA_NOMBREEMPLEADO }}</td>
				<td>{{ $incap -> INCA_FECHAINICIO }}</td>
				<td>{{ $incap -> INCA_TOTALDIAS }}</td>
				<td>{{ $incap -> INCA_FECHAFINAL }}</td>
				<td>{{ $incap -> INCA_CONTINGENCIA }}</td>
				<td>{{ $incap -> INCA_PRIMERDIAAT }}</td>
				<td>{{ $incap -> INCA_DOCUMENTO }}</td>
				<td></td>
			</tr>
			@endforeach
		</tbody>
	</table>

	@include('widgets/modal-delete')
@endsection