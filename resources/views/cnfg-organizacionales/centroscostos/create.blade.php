@extends('layouts.menu')
@section('page_heading', 'Nuevo Centro de costos')

@section('section')
{{ Form::open(['route' => 'cnfg-organizacionales.centroscostos.store', 'class' => 'form-horizontal']) }}

	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

{{ Form::close() }}
@endsection
