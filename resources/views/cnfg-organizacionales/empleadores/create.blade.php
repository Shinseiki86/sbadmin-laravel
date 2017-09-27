@extends('layouts.menu')
@section('page_heading', 'Nuevo Empleador')

@section('section')
{{ Form::open(['route' => 'cnfg-organizacionales.empleadores.store', 'class' => 'form-horizontal']) }}

	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

{{ Form::close() }}
@endsection
