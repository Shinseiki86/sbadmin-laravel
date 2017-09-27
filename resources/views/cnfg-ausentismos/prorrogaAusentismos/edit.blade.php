@extends('layouts.menu')

@section('page_heading', 'Actualizar Prorroga')

@section('section')
	{{ Form::model($prorrogaAusentismo, ['route' => ['cnfg-ausentismos.prorrogaausentismos.update', $prorrogaAusentismo ], 'method' => 'PUT', 'class' => 'form-horizontal' ]) }}

		<!-- Elementos del formulario -->
		@include('cnfg-ausentismos.prorrogaausentismos.fields')

		<!-- Botones -->
		@include('widgets.forms.buttons', ['url' => 'cnfg-ausentismos/prorrogaausentismos'])

	{{ Form::close() }}
@endsection