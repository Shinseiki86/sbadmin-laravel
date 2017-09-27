@extends('layouts.menu')
@section('page_heading', 'Actualizar Riesgo')

@section('section')
{{ Form::model($riesgo, ['action' => ['CnfgOrganizacionales\RiesgoController@update', $riesgo->RIES_ID ], 'method' => 'PUT', 'class' => 'form-horizontal' ]) }}

	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

	<!-- Botones -->
	@include('widgets.forms.buttons', ['url' => 'cnfg-organizacionales/riesgos'])

{{ Form::close() }}
@endsection