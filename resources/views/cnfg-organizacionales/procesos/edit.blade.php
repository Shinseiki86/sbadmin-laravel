@extends('layouts.menu')
@section('page_heading', 'Actualizar Proceso')

@section('section')
{{ Form::model($proceso, ['action' => ['CnfgOrganizacionales\ProcesoController@update', $proceso->PROC_ID ], 'method' => 'PUT', 'class' => 'form-horizontal' ]) }}

	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

	<!-- Botones -->
	@include('widgets.forms.buttons', ['url' => 'cnfg-organizacionales/procesos'])

{{ Form::close() }}
@endsection