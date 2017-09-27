@extends('layouts.menu')
@section('page_heading', 'Nuevo Item del Menú')

@section('section')
{{ Form::open(['route' => 'auth.menu.store', 'class' => 'form-horizontal']) }}

	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

	<!-- Botones -->
	@include('widgets.forms.buttons', ['url' => 'auth/menu'])

{{ Form::close() }}
@endsection
