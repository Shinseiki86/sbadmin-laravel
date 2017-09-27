@extends('layouts.menu')
@section('page_heading', 'Actualizar Proceso')

@section('section')
{{ Form::model($categoria, ['action' => ['CnfgTickets\CategoriaController@update', $categoria->CATE_ID ], 'method' => 'PUT', 'class' => 'form-horizontal' ]) }}

	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

	<!-- Botones -->
	@include('widgets.forms.buttons', ['url' => 'cnfg-tickets/categorias'])

{{ Form::close() }}
@endsection