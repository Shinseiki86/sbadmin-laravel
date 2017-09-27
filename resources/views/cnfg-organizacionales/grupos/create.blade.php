@extends('layouts.menu')
@section('page_heading', 'Nuevo Grupo')

@section('section')	
{{ Form::open(['route' => 'cnfg-organizacionales.grupos.store', 'class' => 'form-horizontal']) }}

	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

	<!-- Botones -->
	@include('widgets.forms.buttons', ['url' => 'cnfg-organizacionales/grupos'])
	
{{ Form::close() }}
@endsection
