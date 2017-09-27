<div class='col-md-4 col-md-offset-4'>
	<!-- Tiau Codigo Field -->
<div class="form-group  {{ $errors->has('TIAU_CODIGO') ? ' has-error' : '' }}">
    {!! Form::label('TIAU_CODIGO', 'Codigo:', ['class' => 'control-label Tiau Codigo']) !!}
	{!! Form::text('TIAU_CODIGO', null, ['class' => 'form-control ']) !!}
	@include('widgets.forms.alerta',['name'=>'TIAU_CODIGO'])
</div>

<!-- Tiau Descripcion Field -->
<div class="form-group  {{ $errors->has('TIAU_DESCRIPCION') ? ' has-error' : '' }}">
    {!! Form::label('TIAU_DESCRIPCION', 'Descripcion:', ['class' => 'control-label Tiau Descripcion']) !!}
	{!! Form::text('TIAU_DESCRIPCION', null, ['class' => 'form-control ']) !!}
	@include('widgets.forms.alerta',['name'=>'TIAU_DESCRIPCION'])
</div>

<!-- Tiau Observaciones Field -->
<div class="form-group  {{ $errors->has('TIAU_OBSERVACIONES') ? ' has-error' : '' }}">
    {!! Form::label('TIAU_OBSERVACIONES', 'Observaciones:', ['class' => 'control-label Tiau Observaciones']) !!}
	{!! Form::text('TIAU_OBSERVACIONES', null, ['class' => 'form-control ']) !!}
	@include('widgets.forms.alerta',['name'=>'TIAU_OBSERVACIONES'])
</div>


</div>
<!-- Submit Field 
<div class="form-group col-sm-12">
    {{-- {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!} --}}
</div>-->
