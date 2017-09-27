@extends('layouts.menu')
@section('page_heading', 'Actualizar Estado de contrato')

@section('section')
{{ Form::model($estadocontrato, ['action' => ['CnfgContratos\EstadoContratoController@update', $estadocontrato->ESCO_ID ], 'method' => 'PUT', 'class' => 'form-horizontal' ]) }}
	
	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

	<!-- Botones -->
	@include('widgets.forms.buttons', ['url' => 'cnfg-contratos/estadoscontratos'])

{{ Form::close() }}
@endsection