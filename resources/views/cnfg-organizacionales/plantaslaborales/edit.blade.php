@extends('layouts.menu')
@section('page_heading', 'Actualizar Planta de Personal')

@section('section')
{{ Form::model($plantalaboral, ['action' => ['CnfgOrganizacionales\PlantaLaboralController@update', $plantalaboral->PALA_ID ], 'method' => 'PUT', 'class' => 'form-horizontal' ]) }}

	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

	<!-- Botones -->
	@include('widgets.forms.buttons', ['url' => 'cnfg-organizacionales/plantaslaborales'])

{{ Form::close() }}
@endsection