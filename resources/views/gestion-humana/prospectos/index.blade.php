@extends('layouts.menu')
@section('title', '/ Prospectos')

@section('page_heading')
	<div class="row">
		<div id="titulo" class="col-xs-8 col-md-6 col-lg-6">
			Prospectos
		</div>
		<div id="btns-top" class="col-xs-4 col-md-6 col-lg-6 text-right">
			<a class='btn btn-primary' role='button' href="{{ route('gestion-humana.prospectos.create') }}" data-tooltip="tooltip" title="Crear Nuevo">
				<i class="fa fa-plus" aria-hidden="true"></i>
			</a>
		</div>
	</div>
@endsection

@section('section')
	<table class="table table-striped" id="tabla">
		<thead>
			<tr>
				<th class="col-md-5">Cedula</th>
				<th class="col-md-5">Fecha de Expedición CC.</th>
				<th class="col-md-5">Primer Nombre</th>
				<th class="col-md-5">Segundo Nombre</th>
				<th class="col-md-5">Primer Apellido</th>
				<th class="col-md-5">Segundo Apellido</th>
				<th class="col-md-5">Sexo</th>
				<th class="col-md-5">Dirección</th>
				<th class="col-md-5">Telefono</th>
				<th class="col-md-5">Celular</th>
				<th class="col-md-5">Correo</th>
				<th class="col-md-5">¿Descartada?</th>
				<th class="col-md-1 all"></th>
			</tr>
		</thead>
		<tbody></tbody>
	</table>

	@include('widgets/modal-delete')
	@include('datatable-ajax', ['urlAjax'=>'getProspectos', 'columns'=>[
		'PROS_CEDULA',
		'PROS_FECHAEXPEDICION',
		'PROS_PRIMERNOMBRE',
		'PROS_SEGUNDONOMBRE',
		'PROS_PRIMERAPELLIDO',
		'PROS_SEGUNDOAPELLIDO',
		'PROS_SEXO',
		'PROS_DIRECCION',
		'PROS_TELEFONO',
		'PROS_CELULAR',
		'PROS_CORREO',
		'PROS_MARCA',
	]])	
@endsection