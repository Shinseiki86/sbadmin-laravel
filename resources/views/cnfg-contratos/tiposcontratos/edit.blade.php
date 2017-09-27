@extends('layouts.menu')
@section('page_heading', 'Actualizar Tipo de contrato')

@section('section')
{{ Form::model($tiposcontrato, ['action' => ['CnfgContratos\TipoContratoController@update', $tiposcontrato->TICO_ID ], 'method' => 'PUT', 'class' => 'form-horizontal' ]) }}
	
	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

	<!-- Botones -->
	@include('widgets.forms.buttons', ['url' => 'cnfg-contratos/tiposcontratos'])

{{ Form::close() }}
@endsection