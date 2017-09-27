@extends('layouts.menu')
@section('title', '/ Decisiones Administrativas')
@include('datatable')

@section('page_heading')
	<div class="row">
		<div id="titulo" class="col-xs-8 col-md-6 col-lg-6">
			Decisiones Administrativas
		</div>
		<div id="btns-top" class="col-xs-4 col-md-6 col-lg-6 text-right">
			<a class='btn btn-primary' role='button' href="{{ route('cnfg-tickets.sanciones.create') }}" data-tooltip="tooltip" title="Crear Nuevo">
				<i class="fa fa-plus" aria-hidden="true"></i>
			</a>
		</div>
	</div>
@endsection

@section('section')

	<table class="table table-striped" id="tabla">
		<thead>
			<tr>
				<th class="col-md-4">Descripción</th>
				<th class="col-md-6">Observaciones</th>
				<th class="hidden-xs col-md-2">Creado</th>
				<th class="col-md-1 all"></th>
			</tr>
		</thead>
		<tbody>
			@foreach($sanciones as $sancion)
			<tr>
				<td>{{ $sancion -> SANC_DESCRIPCION }}</td>
				<td>{{ $sancion -> SANC_OBSERVACIONES }}</td>
				<td>{{ $sancion -> SANC_CREADOPOR }}</td>
				<td>
					<!-- Botón Editar (edit) -->
					<a class="btn btn-small btn-info btn-xs" href="{{ route('cnfg-tickets.sanciones.edit', [ 'SANC_ID' => $sancion->SANC_ID ] ) }}" data-tooltip="tooltip" title="Editar">
						<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
					</a>

					<!-- carga botón de borrar -->
					{{ Form::button('<i class="fa fa-trash" aria-hidden="true"></i>',[
						'class'=>'btn btn-xs btn-danger btn-delete',
						'data-toggle'=>'modal',
						'data-id'=> $sancion->SANC_ID,
						'data-modelo'=> str_upperspace(class_basename($sancion)),
						'data-descripcion'=> $sancion->SANC_DESCRIPCION,
						'data-action'=>'sanciones/'. $sancion->SANC_ID,
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