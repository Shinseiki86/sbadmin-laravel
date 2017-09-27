@extends('layouts.menu')
@section('page_heading', 'Actualizar Tipo de Incidente')

@section('section')
{{ Form::model($tipoincidente, ['action' => ['CnfgTickets\TipoIncidenteController@update', $tipoincidente->TIIN_ID ], 'method' => 'PUT', 'class' => 'form-horizontal' ]) }}

	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

	<!-- Botones -->
	@include('widgets.forms.buttons', ['url' => 'cnfg-tickets/estadosaprobaciones'])

{{ Form::close() }}
@endsection