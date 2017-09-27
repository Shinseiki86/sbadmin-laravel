@extends('layouts.menu')
@section('page_heading', 'Nueva Sanción')

@section('section')
{{ Form::open(['route' => 'cnfg-tickets.sanciones.store', 'class' => 'form-horizontal']) }}

	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

	<!-- Botones -->
	@include('widgets.forms.buttons', ['url' => 'cnfg-tickets/estadosaprobaciones'])

{{ Form::close() }}
@endsection
