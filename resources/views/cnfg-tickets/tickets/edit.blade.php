@extends('layouts.menu')
@section('page_heading', 'Actualizar Ticket')

@section('section')
{{ Form::model($ticket, ['action' => ['CnfgTickets\TicketController@update', $ticket->TICK_ID ], 'method' => 'PUT', 'class' => 'form-horizontal' ]) }}

	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

	<!-- Botones -->
	@include('widgets.forms.buttons', ['url' => 'cnfg-tickets/tickets'])

{{ Form::close() }}
@endsection