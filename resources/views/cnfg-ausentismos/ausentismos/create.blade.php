@extends('layouts.menu')

@section('page_heading', 'Nuevo Ausentismo ')

@section('section')
	{{ Form::open(['route' => 'cnfg-ausentismos.ausentismos.store', 'class' => 'form-horizontal']) }}

		<!-- Elementos del formulario -->
		@include('cnfg-ausentismos.ausentismos.fields')

		<!-- Botones -->
		@include('widgets.forms.buttons', ['url' => 'cnfg-ausentismos/ausentismos'])

	{{ Form::close() }}
{{-- </div> --}}
@endsection

