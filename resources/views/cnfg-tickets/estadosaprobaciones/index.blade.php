@extends('layouts.menu')
@section('title', '/ Estados Aprobaciones')
@include('datatable')

@section('page_heading')
	<div class="row">
		<div id="titulo" class="col-xs-8 col-md-6 col-lg-6">
			Estados de Aprobaciones
		</div>
		<div id="btns-top" class="col-xs-4 col-md-6 col-lg-6 text-right">
			<a class='btn btn-primary' role='button' href="{{ route('cnfg-tickets.estadosaprobaciones.create') }}" data-tooltip="tooltip" title="Crear Nuevo">
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
			@foreach($estadosaprobaciones as $estadoaprobacion)
			<tr>
				<td>{{ $estadoaprobacion -> ESAP_DESCRIPCION }}</td>
				<td style="background-color:{{ $estadoaprobacion -> ESAP_COLOR }}">{{ str_replace(['rgb(', ')'], '', $estadoaprobacion->ESAP_COLOR) }}</td>
				<td>{{ $estadoaprobacion -> ESAP_OBSERVACIONES }}</td>
				<td>{{ $estadoaprobacion -> ESAP_CREADOPOR }}</td>
				<td>
					<!-- Botón Editar (edit) -->
					<a class="btn btn-small btn-info btn-xs" href="{{ route('cnfg-tickets.estadosaprobaciones.edit', [ 'ESAP_ID' => $estadoaprobacion->ESAP_ID ] ) }}" data-tooltip="tooltip" title="Editar">
						<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
					</a>

					<!-- carga botón de borrar -->
					{{ Form::button('<i class="fa fa-trash" aria-hidden="true"></i>',[
						'class'=>'btn btn-xs btn-danger btn-delete',
						'data-toggle'=>'modal',
						'data-id'=> $estadoaprobacion->ESAP_ID,
						'data-modelo'=> str_upperspace(class_basename($estadoaprobacion)),
						'data-descripcion'=> $estadoaprobacion->ESAP_DESCRIPCION,
						'data-action'=>'estadosaprobaciones/'. $estadoaprobacion->ESAP_ID,
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