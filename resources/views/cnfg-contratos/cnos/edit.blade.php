@extends('layouts.menu')
@section('page_heading', 'Actualizar Clasif. de Ocupación')

@section('section')
{{ Form::model($cno, ['action' => ['CnfgContratos\CnosController@update', $cno->CNOS_ID ], 'method' => 'PUT', 'class' => 'form-horizontal' ]) }}
	
	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

	<!-- Botones -->
	@include('widgets.forms.buttons', ['url' => 'cnfg-contratos/cnos'])

{{ Form::close() }}
@endsection