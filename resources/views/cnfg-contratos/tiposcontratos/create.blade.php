@extends('layouts.menu')
@section('page_heading', 'Nuevo Tipo de contrato')

@section('section')
{{ Form::open(['route' => 'cnfg-contratos.tiposcontratos.store', 'class' => 'form-horizontal']) }}
	
	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

	<!-- Botones -->
	@include('widgets.forms.buttons', ['url' => 'cnfg-contratos/tiposcontratos'])

{{ Form::close() }}
@endsection
