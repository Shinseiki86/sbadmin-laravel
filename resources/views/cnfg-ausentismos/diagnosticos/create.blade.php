@extends('layouts.menu')

@section('page_heading', 'Nueva ')

@section('section')
{{-- <div class="col-md-6 col-md-offset-4"> --}}
	{{ Form::open(['route' => 'cnfg-ausentismos.diagnosticos.store', 'class' => 'form-horizontal']) }}

		<!-- Elementos del formulario -->
		@include('cnfg-ausentismos.diagnosticos.fields')

		<!-- Botones -->
		@include('widgets.forms.buttons', ['url' => 'cnfg-ausentismos/diagnosticos'])

	{{ Form::close() }}
{{-- </div> --}}
@endsection

