@extends('layouts.menu')
@section('page_heading', 'Nuevo Estado de Aprobación')

@section('section')
{{ Form::open(['route' => 'cnfg-tickets.estadosaprobaciones.store', 'class' => 'form-horizontal']) }}

	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

	<!-- Botones -->
	@include('widgets.forms.buttons', ['url' => 'cnfg-tickets/estadosaprobaciones'])

{{ Form::close() }}
@endsection
