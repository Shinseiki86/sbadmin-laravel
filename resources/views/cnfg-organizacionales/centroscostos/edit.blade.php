@extends('layouts.menu')
@section('page_heading', 'Actualizar Centro de costo')

@section('section')
{{ Form::model($centrocosto, ['action' => ['CnfgOrganizacionales\CentroCostoController@update', $centrocosto->CECO_ID ], 'method' => 'PUT', 'class' => 'form-horizontal' ]) }}

	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

{{ Form::close() }}
@endsection