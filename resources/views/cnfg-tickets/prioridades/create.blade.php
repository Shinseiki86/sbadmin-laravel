@extends('layouts.menu')
@section('page_heading', 'Nueva Prioridad')

@section('section')
{{ Form::open(['route' => 'cnfg-tickets.prioridades.store', 'class' => 'form-horizontal']) }}

	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

	<!-- Botones -->
	@include('widgets.forms.buttons', ['url' => 'cnfg-tickets/estadosaprobaciones'])

{{ Form::close() }}
@endsection
