@extends('layouts.menu')
@section('page_heading', 'Nuevo Turno')

@section('section')
{{ Form::open(['route' => 'cnfg-organizacionales.turnos.store', 'class' => 'form-horizontal']) }}

	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

	<!-- Botones -->
	@include('widgets.forms.buttons', ['url' => 'cnfg-organizacionales/turnos'])

{{ Form::close() }}
@endsection
