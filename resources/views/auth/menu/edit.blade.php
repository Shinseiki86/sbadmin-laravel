@extends('layouts.menu')
@section('page_heading', 'Actualizar Item del Menú')

@section('section')
{{ Form::model($menu, ['action' => ['Auth\MenuController@update', $menu->MENU_ID ], 'method' => 'PUT', 'class' => 'form-horizontal' ]) }}

	<!-- Elementos del formulario -->
	@rinclude('form-inputs')

	<!-- Botones -->
	@include('widgets.forms.buttons', ['url' => 'auth/menu'])

{{ Form::close() }}
@endsection