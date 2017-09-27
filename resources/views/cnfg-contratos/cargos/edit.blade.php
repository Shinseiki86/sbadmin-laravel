@extends('layouts.menu')
@section('page_heading', 'Actualizar Cargo')

@section('section')
{{ Form::model($cargo, ['action' => ['CnfgContratos\CargoController@update', $cargo->CARG_ID ], 'method' => 'PUT', 'class' => 'form-horizontal' ]) }}

		<!-- Elementos del formulario -->
		@rinclude('form-inputs')

{{ Form::close() }}
@endsection