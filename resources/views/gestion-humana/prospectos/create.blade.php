@extends('layouts.menu')
@section('page_heading', 'Nuevo Prospecto')

@section('section')
{{ Form::open(['route' => 'gestion-humana.prospectos.store', 'class' => 'form-horizontal']) }}

		<!-- Elementos del formulario -->
		@rinclude('form-inputs')

		<!-- Botones -->
		@include('widgets.forms.buttons', ['url' => 'gestion-humana/prospectos'])

{{ Form::close() }}
@endsection
