@extends('layouts.menu')
@section('page_heading', 'Nuevo Riesgo')

@section('section')
{{ Form::open(['route' => 'cnfg-organizacionales.riesgos.store', 'class' => 'form-horizontal']) }}

	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

	<!-- Botones -->
	@include('widgets.forms.buttons', ['url' => 'cnfg-organizacionales/riesgos'])

{{ Form::close() }}
@endsection
