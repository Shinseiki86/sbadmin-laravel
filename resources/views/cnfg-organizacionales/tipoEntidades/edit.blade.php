@extends('layouts.menu')

@section('page_heading', 'Actualizar ')

@section('section')
	{{ Form::model($tipoEntidad, ['route' => ['cnfg-organizacionales.tipoentidades.update', $tipoEntidad ], 'method' => 'PUT', 'class' => 'form-horizontal' ]) }}

		<!-- Elementos del formulario -->
		@include('cnfg-organizacionales.tipoentidades.fields')

		<!-- Botones -->
		@include('widgets.forms.buttons', ['url' => 'cnfg-organizacionales/tipoentidades'])

	{{ Form::close() }}
@endsection