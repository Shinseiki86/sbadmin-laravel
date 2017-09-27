@extends('layouts.menu')
@section('page_heading', 'Nuevo Motivo de Retiro')

@section('section')
{{ Form::open(['route' => 'cnfg-contratos.motivosretiros.store', 'class' => 'form-horizontal']) }}
	
	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

	<!-- Botones -->
	@include('widgets.forms.buttons', ['url' => 'cnfg-contratos/motivosretiros'])

{{ Form::close() }}
@endsection
