@extends('layouts.menu')
@section('page_heading', 'Actualizar clase de contrato')

@section('section')
{{ Form::model($clasecontrato, ['action' => ['CnfgContratos\ClaseContratoController@update', $clasecontrato->CLCO_ID ], 'method' => 'PUT', 'class' => 'form-horizontal' ]) }}
	
	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

	<!-- Botones -->
	@include('widgets.forms.buttons', ['url' => 'cnfg-contratos/clasescontratos'])
	
{{ Form::close() }}
@endsection