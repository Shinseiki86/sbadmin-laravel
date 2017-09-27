@extends('layouts.menu')
@section('page_heading', 'Actualizar Motivo de Retiro')

@section('section')
{{ Form::model($motivoretiro, ['action' => ['CnfgContratos\MotivoRetiroController@update', $motivoretiro->MORE_ID ], 'method' => 'PUT', 'class' => 'form-horizontal' ]) }}
	
	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

	<!-- Botones -->
	@include('widgets.forms.buttons', ['url' => 'cnfg-contratos/motivosretiros'])

{{ Form::close() }}
@endsection