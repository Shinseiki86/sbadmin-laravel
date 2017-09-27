@extends('layouts.menu')
@section('page_heading', 'Nueva Categoría')

@section('section')
{{ Form::open(['route' => 'cnfg-tickets.categorias.store', 'class' => 'form-horizontal']) }}

	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

	<!-- Botones -->
	@include('widgets.forms.buttons', ['url' => 'cnfg-tickets/categorias'])

{{ Form::close() }}
@endsection
