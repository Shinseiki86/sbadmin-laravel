@extends('layouts.menu')

@section('page_heading', 'Agregar Tipo Entidad')

@section('section')
{{-- <div class="col-md-6 col-md-offset-4"> --}}
	{{ Form::open(['route' => 'cnfg-organizacionales.tipoentidades.store', 'class' => 'form-horizontal']) }}

		<!-- Elementos del formulario -->
		@include('cnfg-organizacionales.tipoentidades.fields')

		<!-- Botones -->
		@include('widgets.forms.buttons', ['url' => 'cnfg-organizacionales/tipoentidades'])

	{{ Form::close() }}
{{-- </div> --}}
@endsection

