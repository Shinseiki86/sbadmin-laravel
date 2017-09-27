@extends('layouts.menu')
@section('title', '/ Empleadores')
@include('datatable')

@section('page_heading')
	<div class="row">
		<div id="titulo" class="col-xs-8 col-md-6 col-lg-6">
			Empleadores
		</div>
		<div id="btns-top" class="col-xs-4 col-md-6 col-lg-6 text-right">
			<a class='btn btn-primary' role='button' href="{{ route('cnfg-organizacionales.empleadores.create') }}" data-tooltip="tooltip" title="Crear Nuevo">
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
				<th class="col-md-3">NIT</th>
				<th class="col-md-3">Nombre Comercial</th>
				<th class="col-md-3">Representante</th>
				<th class="col-md-3">Cedula</th>
				<th class="col-md-3">Ciudad de Expedición</th>
				<th class="col-md-3">Dirección</th>
				<th class="col-md-3">Ciudad</th>
				<th class="col-md-2">Responsable G.H</th>
				<th class="col-md-2">Gerencias</th>
				<th class="hidden-xs col-md-1">Creado</th>
				<th class="col-md-1 all"></th>
			</tr>
		</thead>
		<tbody>
			@foreach($empleadores as $empleador)
			<tr>
				<td>{{ $empleador -> EMPL_RAZONSOCIAL }}</td>
				<td>{{ $empleador -> EMPL_NIT }}</td>
				<td>{{ $empleador -> EMPL_NOMBRECOMERCIAL }}</td>
				<td>{{ $empleador -> EMPL_NOMBREREPRESENTANTE }}</td>
				<td>{{ $empleador -> EMPL_CEDULAREPRESENTANTE }}</td>
				<td>{{ $empleador -> ciudad_expedicion -> CIUD_NOMBRE }}</td>
				<td>{{ $empleador -> EMPL_DIRECCION }}</td>
				<td>{{ $empleador -> ciudad_domicilio -> CIUD_NOMBRE }}</td>
				<td>{{ isset($empleador ->PROS_ID) ? nombre_empleado($empleador -> prospecto -> PROS_ID) : '' }}</td>
				<td>{{ $empleador -> gerencias -> count() }}</td>
				<td>{{ $empleador -> EMPL_CREADOPOR }}</td>
				<td>
					<!-- Botón Editar (edit) -->
					<a class="btn btn-small btn-info btn-xs" href="{{ route('cnfg-organizacionales.empleadores.edit', [ 'EMPL_ID' => $empleador->EMPL_ID ] ) }}" data-tooltip="tooltip" title="Editar">
						<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
					</a>

					<!-- carga botón de borrar -->
					{{ Form::button('<i class="fa fa-trash" aria-hidden="true"></i>',[
						'class'=>'btn btn-xs btn-danger btn-delete',
						'data-toggle'=>'modal',
						'data-id'=> $empleador->EMPL_ID,
						'data-modelo'=> str_upperspace(class_basename($empleador)),
						'data-descripcion'=> $empleador->EMPL_RAZONSOCIAL,
						'data-action'=>'empleadores/'. $empleador->EMPL_ID,
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