@extends('layouts.menu')
@section('page_heading', 'Nueva Clasif. de Ocupación')

@section('section')
{{ Form::open(['route' => 'cnfg-contratos.cnos.store', 'class' => 'form-horizontal']) }}
	
	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

	<!-- Botones -->
	@include('widgets.forms.buttons', ['url' => 'cnfg-contratos/cnos'])

{{ Form::close() }}
@endsection
