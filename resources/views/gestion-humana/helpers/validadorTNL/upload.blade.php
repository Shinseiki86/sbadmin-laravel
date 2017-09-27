@extends('layouts.menu')

@section('page_heading', 'Validador de TNL Vs. INCAPACIDADES')

@section('section')

	
	{{ Form::open(['route' => 'tnl.store', 'class' => 'form-vertical', 'files'=>true]) }}

		<div class="text-right">
			<a class='btn btn-info' role='button' href="{{ asset('templates/TemplateCargaTNL_INCAP.xlsx') }}" download>
				<i class="fa fa-download" aria-hidden="true"></i> Descargar plantilla
			</a>
		</div>

		<div class="form-group">
		<div class="col-md-7">
			{{ Form::label('archivo', 'Archivo TNL') }}
			{{ Form::file('archivotnl', [ 'class' => 'form-control', 'required' ]) }}
			</div>
		</div>

		<div class="form-group">
		<div class="col-md-7">
			{{ Form::label('archivo', 'Archivo Incapacidades') }}
			{{ Form::file('archivoincap', [ 'class' => 'form-control', 'required' ]) }}
			</div>
		</div>

		<br>	
		<!-- Botones -->
		<div class="form-group">
			<div class="col-md-6 col-md-offset-4 text-right">
				<a class="btn btn-warning" role="button" href="{{ route('tnl.index') }}" data-tooltip="tooltip" title="Regresar">
					<i class="fa fa-arrow-left" aria-hidden="true"></i>
				</a>
				{{ Form::button('<i class="fa fa-floppy-o" aria-hidden="true"></i>', [
					'class'=>'btn btn-primary',
					'type'=>'submit',
					'data-tooltip'=>'tooltip',
					'title'=>'Guardar y Analisar',
				]) }}
			</div>
		</div>


	{{ Form::close() }}
@endsection