<div class='col-md-6 col-md-offset-4'>
<!-- Diag Codigo Field -->
<div class="form-group  {{ $errors->has('DIAG_CODIGO') ? ' has-error' : '' }}">
    {!! Form::label('DIAG_CODIGO', 'Diag Codigo:', ['class' => 'control-label Diag Codigo']) !!}
	{!! Form::text('DIAG_CODIGO', null, ['class' => 'form-control ']) !!}
	@include('widgets.forms.alerta',['name'=>'DIAG_CODIGO'])
</div>

<!-- Diag Descripcion Field -->
<div class="form-group  {{ $errors->has('DIAG_DESCRIPCION') ? ' has-error' : '' }}">
    {!! Form::label('DIAG_DESCRIPCION', 'Diag Descripcion:', ['class' => 'control-label Diag Descripcion']) !!}
	{!! Form::text('DIAG_DESCRIPCION', null, ['class' => 'form-control ']) !!}
	@include('widgets.forms.alerta',['name'=>'DIAG_DESCRIPCION'])
</div>
</div>


<!-- Submit Field 
<div class="form-group col-sm-12">
    {{-- {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!} --}}
</div>-->
