@extends('layouts.menu')

@section('page_heading', 'Actualizar ')

@section('section')
	{{ Form::model($diagnostico, ['route' => ['cnfg-ausentismos.diagnosticos.update', $diagnostico ], 'method' => 'PUT', 'class' => 'form-horizontal' ]) }}

		<!-- Elementos del formulario -->
		@include('cnfg-ausentismos.diagnosticos.fields')

		<!-- Botones -->
		@include('widgets.forms.buttons', ['url' => 'cnfg-ausentismos/diagnosticos'])

	{{ Form::close() }}
@endsection