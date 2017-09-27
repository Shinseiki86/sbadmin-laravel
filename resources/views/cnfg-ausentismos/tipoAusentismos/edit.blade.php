@extends('layouts.menu')

@section('page_heading', 'Actualizar Tipo de Ausentismo')

@section('section')
	{{ Form::model($tipoAusentismo, ['route' => ['cnfg-ausentismos.tipoausentismos.update', $tipoAusentismo ], 'method' => 'PUT', 'class' => 'form-horizontal' ]) }}

		<!-- Elementos del formulario -->
		@include('cnfg-ausentismos.tipoausentismos.fields')

		<!-- Botones -->
		@include('widgets.forms.buttons', ['url' => 'cnfg-ausentismos/tipoausentismos'])

	{{ Form::close() }}
@endsection