@extends('layouts.menu')
@section('title', '/ Estados Tickets')
@include('datatable')

@section('page_heading')
	<div class="row">
		<div id="titulo" class="col-xs-8 col-md-6 col-lg-6">
			Estados de Ticket
		</div>
		<div id="btns-top" class="col-xs-4 col-md-6 col-lg-6 text-right">
			<a class='btn btn-primary' role='button' href="{{ route('cnfg-tickets.estadostickets.create') }}" data-tooltip="tooltip" title="Crear Nuevo">
				<i class="fa fa-plus" aria-hidden="true"></i>
			</a>
		</div>
	</div>
@endsection

@section('section')

	<table class="table table-striped" id="tabla">
		<thead>
			<tr>
				<th class="col-md-3">Descripción</th>
				<th class="col-md-1">Color</th>
				<th class="col-md-4">Observaciones</th>
				<th class="hidden-xs col-md-1">Creado</th>
				<th class="col-md-1 all"></th>
			</tr>
		</thead>
		<tbody>
			@foreach($estadostickets as $prioridad)
			<tr>
				<td>{{ $prioridad -> ESTI_DESCRIPCION }}</td>
				<td style="background-color:{{ $prioridad -> ESTI_COLOR }}">{{ str_replace(['rgb(', ')'], '', $prioridad->ESTI_COLOR) }}</td>
				<td>{{ $prioridad -> ESTI_OBSERVACIONES }}</td>
				<td>{{ $prioridad -> ESTI_CREADOPOR }}</td>
				<td>
					<!-- Botón Editar (edit) -->
					<a class="btn btn-small btn-info btn-xs" href="{{ route('cnfg-tickets.estadostickets.edit', [ 'ESTI_ID' => $prioridad->ESTI_ID ] ) }}" data-tooltip="tooltip" title="Editar">
						<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
					</a>

					<!-- carga botón de borrar -->
					{{ Form::button('<i class="fa fa-trash" aria-hidden="true"></i>',[
						'class'=>'btn btn-xs btn-danger btn-delete',
						'data-toggle'=>'modal',
						'data-id'=> $prioridad->ESTI_ID,
						'data-modelo'=> str_upperspace(class_basename($prioridad)),
						'data-descripcion'=> $prioridad->ESTI_DESCRIPCION,
						'data-action'=>'estadostickets/'. $prioridad->ESTI_ID,
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