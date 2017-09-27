@extends('layouts.menu')
@section('page_heading', 'Nuevo Cargo')

@section('section')
{{ Form::open(['route' => 'cnfg-contratos.cargos.store', 'class' => 'form-horizontal']) }}

	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

{{ Form::close() }}
@endsection
