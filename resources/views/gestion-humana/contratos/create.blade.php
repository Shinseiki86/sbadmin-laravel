@extends('layouts.menu')
@section('page_heading', 'Nuevo Contrato')

@section('section')
	{{ Form::open(['route' => 'gestion-humana.contratos.store', 'class' => 'form-horizontal']) }}

		<!-- Elementos del formulario -->
		@rinclude('form-inputs')

		<!-- Botones -->
		@include('widgets.forms.buttons', ['url' => 'gestion-humana/contratos'])

	{{ Form::close() }}
@endsection
