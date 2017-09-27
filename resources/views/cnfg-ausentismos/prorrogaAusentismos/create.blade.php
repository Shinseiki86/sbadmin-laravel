@extends('layouts.menu')

@section('page_heading', 'Nueva Prorroga')

@section('section')
{{-- <div class="col-md-6 col-md-offset-4"> --}}
	<div class='col-md-8 col-md-offset-2 form-horizontal'>	
		@include('cnfg-ausentismos.prorrogaausentismos.datosAusentismo')
	</div>
	
	{{ Form::open(['route' => 'cnfg-ausentismos.prorrogaausentismos.store', 'class' => 'form-horizontal']) }}

		<!-- Elementos del formulario -->
		@include('cnfg-ausentismos.prorrogaausentismos.fields')

		<!-- Botones -->
		@include('widgets.forms.buttons', ['url' => 'cnfg-ausentismos/prorrogaausentismos'])

	{{ Form::close() }}
{{-- </div> --}}
@endsection

