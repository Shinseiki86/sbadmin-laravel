@extends('layouts.menu')
@section('page_heading', 'Actualizar Turno')

@section('section')
{{ Form::model($turno, ['action' => ['CnfgOrganizacionales\TurnoController@update', $turno->TURN_ID ], 'method' => 'PUT', 'class' => 'form-horizontal' ]) }}

	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

	<!-- Botones -->
	@include('widgets.forms.buttons', ['url' => 'cnfg-organizacionales/turnos'])

{{ Form::close() }}
@endsection