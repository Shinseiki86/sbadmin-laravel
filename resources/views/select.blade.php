@extends('layouts.menu')

@section('page_heading', 'Nueva ')

@section('section')
	 {!! Form::select('departamentos',$departamentos,null,['id'=>'DEPA_ID','class'=>' productcategory js-example-responsive form-control selectpicker','style'=>'width: 30%']) !!}


		{!! Form::select('ciudad',['placeholder'=>'Selecciona'],null,['id'=>'ciudad','class'=>'ciudades selectpicker','style'=>'width: 30%']) !!}		
		
@endsection

@push('scripts')
	
	@include('select-dinamico', ['url'=>'buscaCiudad', 'selectPadre'=>'DEPA_ID', 'selectHijo'=>'ciudad ', 'idBusqueda'=>'CIUD_ID', 'nombreBusqueda'=>'CIUD_NOMBRE', 'prepend'=>'Seleccione una Ciudad'])
	
@endpush
