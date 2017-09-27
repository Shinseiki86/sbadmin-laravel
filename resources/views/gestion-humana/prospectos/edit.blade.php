@extends('layouts.menu')
@section('page_heading', 'Actualizar Prospecto')

@section('section')
{{ Form::model($prospecto, ['action' => ['GestionHumana\ProspectoController@update', $prospecto->PROS_ID ], 'method' => 'PUT', 'class' => 'form-horizontal' ]) }}

		<!-- Elementos del formulario -->
		@include('gestion-humana.prospectos.form-inputs')

		<!-- Botones -->
		@include('widgets.forms.buttons', ['url' => 'gestion-humana/prospectos'])

{{ Form::close() }}
@endsection
