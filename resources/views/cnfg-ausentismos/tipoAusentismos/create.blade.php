@extends('layouts.menu')

@section('page_heading', 'Nuevo Tipo de Ausentismo ')

@section('section')
{{-- <div class="col-md-6 col-md-offset-4"> --}}
	{{ Form::open(['route' => 'cnfg-ausentismos.tipoausentismos.store', 'class' => 'form-horizontal']) }}

		<!-- Elementos del formulario -->
		@include('cnfg-ausentismos.tipoausentismos.fields')

		<!-- Botones -->
		@include('widgets.forms.buttons', ['url' => 'cnfg-ausentismos/tipoausentismos'])

	{{ Form::close() }}
{{-- </div> --}}
@endsection

