@extends('layouts.menu')
@section('title', '/ Riesgos')
@include('datatable')

@section('page_heading')
	<div class="row">
		<div id="titulo" class="col-xs-8 col-md-6 col-lg-6">
			Riesgos ARL
		</div>
		<div id="btns-top" class="col-xs-4 col-md-6 col-lg-6 text-right">
			<a class='btn btn-primary' role='button' href="{{ route('cnfg-organizacionales.riesgos.create') }}" data-tooltip="tooltip" title="Crear Nuevo">
				<i class="fa fa-plus" aria-hidden="true"></i>
			</a>
		</div>
	</div>
@endsection

@section('section')

	<table class="table table-striped" id="tabla">
		<thead>
			<tr>
				<th class="col-md-6">Riesgo</th>
				<th class="col-md-4">Factor</th>
				<th class="hidden-xs col-md-1">Creado</th>
				<th class="col-md-1"></th>
			</tr>
		</thead>
		<tbody>
			@foreach($riesgos as $riesgo)
			<tr>
				<td>{{ $riesgo -> RIES_DESCRIPCION }}</td>
				<td>{{ $riesgo -> RIES_FACTOR }}</td>
				<td>{{ $riesgo -> RIES_CREADOPOR }}</td>
				<td>
					<!-- Botón Editar (edit) -->
					<a class="btn btn-small btn-info btn-xs" href="{{ route('cnfg-organizacionales.riesgos.edit', [ 'RIES_ID' => $riesgo->RIES_ID ] ) }}" data-tooltip="tooltip" title="Editar">
						<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
					</a>

					<!-- carga botón de borrar -->
					{{ Form::button('<i class="fa fa-trash" aria-hidden="true"></i>',[
						'class'=>'btn btn-xs btn-danger btn-delete',
						'data-toggle'=>'modal',
						'data-id'=> $riesgo->RIES_ID,
						'data-modelo'=> str_upperspace(class_basename($riesgo)),
						'data-descripcion'=> $riesgo->RIES_DESCRIPCION,
						'data-action'=>'riesgos/'. $riesgo->RIES_ID,
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