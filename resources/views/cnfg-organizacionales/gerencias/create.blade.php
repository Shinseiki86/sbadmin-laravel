@extends('layouts.menu')
@section('page_heading', 'Nueva Gerencia')

@section('section')
{{ Form::open(['route' => 'cnfg-organizacionales.gerencias.store', 'class' => 'form-horizontal']) }}

	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

	<!-- Botones -->
	@include('widgets.forms.buttons', ['url' => 'cnfg-organizacionales/gerencias'])

{{ Form::close() }}
@endsection
