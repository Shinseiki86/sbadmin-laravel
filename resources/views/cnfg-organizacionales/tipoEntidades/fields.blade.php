<div class='col-md-6 col-md-offset-4'>
	<!-- Tien Codigo Field -->
	<div class="form-group  {{ $errors->has('TIEN_CODIGO') ? ' has-error' : '' }}">
		{!! Form::label('TIEN_CODIGO', 'Codigo:', ['class' => 'control-label Tien Codigo']) !!}
		{!! Form::text('TIEN_CODIGO', null, ['class' => 'form-control ']) !!}
		@include('widgets.forms.alerta',['name'=>'TIEN_CODIGO'])
	</div>
	<!-- Tien Descripcion Field -->
	<div class="form-group  {{ $errors->has('TIEN_DESCRIPCION') ? ' has-error' : '' }}">
		{!! Form::label('TIEN_DESCRIPCION', 'Descripcion:', ['class' => 'control-label Tien Descripcion']) !!}
		{!! Form::text('TIEN_DESCRIPCION', null, ['class' => 'form-control ']) !!}
		@include('widgets.forms.alerta',['name'=>'TIEN_DESCRIPCION'])
	</div>
	<!-- Tien Observaciones Field -->
	<div class="form-group  {{ $errors->has('TIEN_OBSERVACIONES') ? ' has-error' : '' }}">
		{!! Form::label('TIEN_OBSERVACIONES', 'Observaciones:', ['class' => 'control-label Tien Observaciones']) !!}
		{!! Form::text('TIEN_OBSERVACIONES', null, ['class' => 'form-control ']) !!}
		@include('widgets.forms.alerta',['name'=>'TIEN_OBSERVACIONES'])
	</div>
</div>