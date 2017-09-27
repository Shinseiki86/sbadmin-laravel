@extends('layouts.menu')
@section('page_heading', 'Actualizar Prioridad')

@section('section')
{{ Form::model($prioridad, ['action' => ['CnfgTickets\PrioridadController@update', $prioridad->PRIO_ID ], 'method' => 'PUT', 'class' => 'form-horizontal' ]) }}

	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

	<!-- Botones -->
	@include('widgets.forms.buttons', ['url' => 'cnfg-tickets/estadosaprobaciones'])

{{ Form::close() }}
@endsection