@extends('layouts.menu')
@section('page_heading', 'Nueva Clase de contrato')

@section('section')
{{ Form::open(['route' => 'cnfg-contratos.estadoscontratos.store', 'class' => 'form-horizontal']) }}
	
	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

	<!-- Botones -->
	@include('widgets.forms.buttons', ['url' => 'cnfg-contratos/estadoscontratos'])

{{ Form::close() }}
@endsection
