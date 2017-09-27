@extends('layouts.menu')

@section('page_heading', 'Nuevo Concepto Ausencia')

@section('section')
{{-- <div class="col-md-6 col-md-offset-4"> --}}
	{{ Form::open(['route' => 'cnfg-ausentismos.conceptoausencias.store', 'class' => 'form-horizontal']) }}

		<!-- Elementos del formulario -->
		@include('cnfg-ausentismos.conceptoausencias.fields')

		<!-- Botones -->
		@include('widgets.forms.buttons', ['url' => 'cnfg-ausentismos/conceptoausencias'])

	{{ Form::close() }}
{{-- </div> --}}
@endsection

