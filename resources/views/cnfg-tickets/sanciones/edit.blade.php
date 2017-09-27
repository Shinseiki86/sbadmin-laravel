@extends('layouts.menu')
@section('page_heading', 'Actualizar Decisión Administrativa')

@section('section')
{{ Form::model($sancion, ['action' => ['CnfgTickets\SancionController@update', $sancion->SANC_ID ], 'method' => 'PUT', 'class' => 'form-horizontal' ]) }}

	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

	<!-- Botones -->
	@include('widgets.forms.buttons', ['url' => 'cnfg-tickets/estadosaprobaciones'])

{{ Form::close() }}
@endsection