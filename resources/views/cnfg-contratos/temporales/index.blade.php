@extends('layouts.menu')
@section('title', '/ Temporales')
@include('datatable')

@section('page_heading')
	<div class="row">
		<div id="titulo" class="col-xs-8 col-md-6 col-lg-6">
			Empresas Temporales
		</div>
		<div id="btns-top" class="col-xs-4 col-md-6 col-lg-6 text-right">
			<a class='btn btn-primary' role='button' href="{{ route('cnfg-contratos.temporales.create') }}" data-tooltip="tooltip" title="Crear Nuevo">
				<i class="fa fa-plus" aria-hidden="true"></i>
			</a>
		</div>
	</div>
@endsection

@section('section')

	<table class="table table-striped" id="tabla">
		<thead>
			<tr>
				<th class="col-md-3">Razón Social</th>
				<th class="col-md-3">Nombre Comercial</th>
				<th class="col-md-3">Dirección</th>
				<th class="col-md-3">Responsable</th>
				<th class="hidden-xs col-md-1">Creado</th>
				<th class="col-md-1 all"></th>
			</tr>
		</thead>

		<tbody>
			@foreach($temporales as $temporal)
			<tr>
				<td>{{ $temporal -> TEMP_RAZONSOCIAL }}</td>
				<td>{{ $temporal -> TEMP_NOMBRECOMERCIAL }}</td>
				<td>{{ $temporal -> TEMP_DIRECCION }}</td>
				<td>{{ isset($temporal ->PROS_ID) ? nombre_empleado($temporal -> PROS_ID) : '' }}</td>
				<td>{{ $temporal -> TEMP_CREADOPOR }}</td>
				<td>
					<!-- Botón Editar (edit) -->
					<a class="btn btn-small btn-info btn-xs" href="{{ route('cnfg-contratos.temporales.edit', [ 'TEMP_ID' => $temporal->TEMP_ID ] ) }}" data-tooltip="tooltip" title="Editar">
						<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
					</a>

					<!-- carga botón de borrar -->
					{{ Form::button('<i class="fa fa-trash" aria-hidden="true"></i>',[
						'class'=>'btn btn-xs btn-danger btn-delete',
						'data-toggle'=>'modal',
						'data-id'=> $temporal->TEMP_ID,
						'data-modelo'=> str_upperspace(class_basename($temporal)),
						'data-descripcion'=> $temporal->TEMP_RAZONSOCIAL,
						'data-action'=>'temporales/'. $temporal->TEMP_ID,
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