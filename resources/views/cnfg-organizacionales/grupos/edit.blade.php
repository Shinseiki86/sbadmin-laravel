@extends('layouts.menu')
@section('page_heading', 'Actualizar Grupo')

@section('section')
{{ Form::model($grupo, ['action' => ['CnfgOrganizacionales\GrupoController@update', $grupo->GRUP_ID ], 'method' => 'PUT', 'class' => 'form-horizontal' ]) }}

	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

	<!-- Botones -->
	@include('widgets.forms.buttons', ['url' => 'cnfg-organizacionales/grupos'])

{{ Form::close() }}
@endsection