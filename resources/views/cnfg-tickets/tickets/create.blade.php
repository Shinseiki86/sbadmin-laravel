@extends('layouts.menu')
@section('page_heading', 'Gestión de Tickets')

@section('section')
{{ Form::open(['route' => 'cnfg-tickets.tickets.store', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) }}

	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

	<!-- Botones -->
	@include('widgets.forms.buttons', ['url' => 'cnfg-tickets/tickets'])

{{ Form::close() }}
@endsection
