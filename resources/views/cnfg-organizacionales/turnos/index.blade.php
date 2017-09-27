@extends('layouts.menu')
@section('title', '/ Turnos')
@include('datatable')

@section('page_heading')
	<div class="row">
		<div id="titulo" class="col-xs-8 col-md-6 col-lg-6">
			Turnos
		</div>
		<div id="btns-top" class="col-xs-4 col-md-6 col-lg-6 text-right">
			<a class='btn btn-primary' role='button' href="{{ route('cnfg-organizacionales.turnos.create') }}" data-tooltip="tooltip" title="Crear Nuevo">
				<i class="fa fa-plus" aria-hidden="true"></i>
			</a>
		</div>
	</div>
@endsection

@section('section')

	<table class="table table-striped" id="tabla">
		<thead>
			<tr>
				<th class="col-md-2">Codigo</th>
				<th class="col-md-4">Descripción</th>
				<th class="col-md-4">Tipo de Turno</th>
				<th class="col-md-2">Inicio P.I</th>
				<th class="col-md-2">Fin P.I</th>
				<th class="col-md-2">Inicio S.I</th>
				<th class="col-md-2">Fin S.I</th>
				<th class="col-md-6">Observaciones</th>
				<th class="hidden-xs col-md-1">Creado</th>
				<th class="col-md-1 all"></th>
			</tr>
		</thead>
		<tbody>
			@foreach($turnos as $turno)
			<tr>
				<td>{{ $turno -> TURN_CODIGO }}</td>
				<td>{{ $turno -> TURN_DESCRIPCION }}</td>
				<td>{{ $turno -> TURN_TIPOTURNO }}</td>
				<td>{{ $turno -> TURN_HORAINICIOPI }}</td>
				<td>{{ $turno -> TURN_HORAFINALPI }}</td>
				<td>{{ $turno -> TURN_HORAINICIOSI }}</td>
				<td>{{ $turno -> TURN_HORAFINALSI }}</td>
				<td>{{ $turno -> TURN_OBSERVACIONES }}</td>
				<td>{{ $turno -> TURN_CREADOPOR }}</td>
				<td>
					<!-- Botón Editar (edit) -->
					<a class="btn btn-small btn-info btn-xs" href="{{ route('cnfg-organizacionales.turnos.edit', [ 'TURN_ID' => $turno->TURN_ID ] ) }}" data-tooltip="tooltip" title="Editar">
						<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
					</a>

					<!-- carga botón de borrar -->
					{{ Form::button('<i class="fa fa-trash" aria-hidden="true"></i>',[
						'class'=>'btn btn-xs btn-danger btn-delete',
						'data-toggle'=>'modal',
						'data-id'=> $turno->TURN_ID,
						'data-modelo'=> str_upperspace(class_basename($turno)),
						'data-descripcion'=> $turno->TURN_DESCRIPCION,
						'data-action'=>'turnos/'. $turno->TURN_ID,
						'data-target'=>'#pregModalDelete',
						'data-tooltip'=>'tooltip',
						'title'=>'Borrar',
					])}}
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>

	@include('widgets/modal-delete')
@endsection