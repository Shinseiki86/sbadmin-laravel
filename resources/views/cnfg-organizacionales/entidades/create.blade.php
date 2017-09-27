@extends('layouts.menu')

@section('page_heading', 'Crear Entidad ')

@section('section')
{{-- <div class="col-md-6 col-md-offset-4"> --}}
	{{ Form::open(['route' => 'cnfg-organizacionales.entidades.store', 'class' => 'form-horizontal']) }}

		<!-- Elementos del formulario -->
		@include('cnfg-organizacionales.entidades.fields')

		<!-- Botones -->
		@include('widgets.forms.buttons', ['url' => 'cnfg-organizacionales/entidades'])

	{{ Form::close() }}
{{-- </div> --}}
@endsection

