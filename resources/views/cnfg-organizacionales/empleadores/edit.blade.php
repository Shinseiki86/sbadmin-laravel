@extends('layouts.menu')
@section('page_heading', 'Actualizar Empleador')

@section('section')
{{ Form::model($empleador, ['action' => ['CnfgOrganizacionales\EmpleadorController@update', $empleador->EMPL_ID ], 'method' => 'PUT', 'class' => 'form-horizontal' ]) }}
	
	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

{{ Form::close() }}
@endsection