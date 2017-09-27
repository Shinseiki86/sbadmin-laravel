@extends('layouts.menu')
@section('page_heading', 'Nuevo Tipo de empleador')

@section('section')
{{ Form::open(['route' => 'cnfg-organizacionales.tiposempleadores.store', 'class' => 'form-horizontal']) }}

	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

	<!-- Botones -->
	@include('widgets.forms.buttons', ['url' => 'cnfg-organizacionales/tiposempleadores'])

{{ Form::close() }}
@endsection
