@extends('layouts.menu')
@section('page_heading', 'Actualizar Estado de Ticket')

@section('section')
{{ Form::model($estadoticket, ['action' => ['CnfgTickets\EstadoTicketController@update', $estadoticket->ESTI_ID ], 'method' => 'PUT', 'class' => 'form-horizontal' ]) }}

	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

	<!-- Botones -->
	@include('widgets.forms.buttons', ['url' => 'cnfg-tickets/estadostickets'])

{{ Form::close() }}
@endsection