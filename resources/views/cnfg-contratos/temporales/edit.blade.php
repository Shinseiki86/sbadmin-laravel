@extends('layouts.menu')
@section('page_heading', 'Actualizar Empresa Temporal')

@section('section')
{{ Form::model($temporal, ['action' => ['CnfgContratos\TemporalController@update', $temporal->TEMP_ID ], 'method' => 'PUT', 'class' => 'form-horizontal' ]) }}
	
	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

	<!-- Botones -->
	@include('widgets.forms.buttons', ['url' => 'cnfg-contratos/temporales'])

{{ Form::close() }}
@endsection