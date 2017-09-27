@extends('layouts.menu')

@section('page_heading', 'Actualizar ')

@section('section')
	{{ Form::model($entidad, ['route' => ['cnfg-organizacionales.entidades.update', $entidad ], 'method' => 'PUT', 'class' => 'form-horizontal' ]) }}

		<!-- Elementos del formulario -->
		@include('cnfg-organizacionales.entidades.fields')

		<!-- Botones -->
		@include('widgets.forms.buttons', ['url' => 'cnfg-organizacionales/entidades'])

	{{ Form::close() }}
@endsection