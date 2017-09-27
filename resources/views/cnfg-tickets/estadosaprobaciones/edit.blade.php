@extends('layouts.menu')
@section('page_heading', 'Actualizar Estado de Aprobación')

@section('section')
{{ Form::model($estadoaprobacion, ['action' => ['CnfgTickets\EstadoAprobacionController@update', $estadoaprobacion->ESAP_ID ], 'method' => 'PUT', 'class' => 'form-horizontal' ]) }}

	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

	<!-- Botones -->
	@include('widgets.forms.buttons', ['url' => 'cnfg-tickets/estadosaprobaciones'])

{{ Form::close() }}
@endsection