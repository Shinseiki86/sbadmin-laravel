@extends('layouts.menu')
@section('page_heading', 'Nuevo Tipo de Incidente')

@section('section')
{{ Form::open(['route' => 'cnfg-tickets.tiposincidentes.store', 'class' => 'form-horizontal']) }}

	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

	<!-- Botones -->
	@include('widgets.forms.buttons', ['url' => 'cnfg-tickets/estadosaprobaciones'])

{{ Form::close() }}
@endsection
