@extends('layouts.menu')
@section('page_heading', 'Actualizar Tipo de empleador')

@section('section')
{{ Form::model($tipoempleador, ['action' => ['CnfgOrganizacionales\TipoEmpleadorController@update', $tipoempleador->TIEM_ID ], 'method' => 'PUT', 'class' => 'form-horizontal' ]) }}

	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

	<!-- Botones -->
	@include('widgets.forms.buttons', ['url' => 'cnfg-organizacionales/tiposempleadores'])

{{ Form::close() }}
@endsection