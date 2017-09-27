@include('chosen')
<div class='col-md-8 col-md-offset-2'>
	<!-- Coau Codigo Field -->
	<div class="col-md-13 ">
		<div class="col-xs-4"> 
			<div class="form-group  {{ $errors->has('COAU_CODIGO') ? ' has-error' : '' }}">
			    {!! Form::label('COAU_CODIGO', 'Codigo:', ['class' => 'control-label Coau Codigo']) !!}
				{!! Form::text('COAU_CODIGO', null, ['class' => 'form-control ']) !!}
				@include('widgets.forms.alerta',['name'=>'COAU_CODIGO'])
			</div>
		</div>	
		<!-- Coau Descripcion Field -->
		<div class="col-xs-8"> 
			<div class="form-group  {{ $errors->has('COAU_DESCRIPCION') ? ' has-error' : '' }}">
			    {!! Form::label('COAU_DESCRIPCION', 'Descripcion:', ['class' => 'control-label Coau Descripcion']) !!}
				{!! Form::text('COAU_DESCRIPCION', null, ['class' => 'form-control ']) !!}
				@include('widgets.forms.alerta',['name'=>'COAU_DESCRIPCION'])
			</div>
		</div>
	</div>
	
	<!-- Tiau Id Field -->
	<div class="col-md-13 ">
		@include('widgets.forms.input', ['type'=>'select', 'name'=>'TIAU_ID', 'label'=>'Tipo Ausentismo', 'data'=>$arrTipoAusentismo,'column'=>5,'placeholder'=>'Seleccione un Tipo de Ausentismo','allowClear'=>true])

		<!-- Tien Id Field -->

		@include('widgets.forms.input', ['type'=>'select', 'name'=>'TIEN_ID', 'label'=>'Tipo Entidad', 'data'=>$arrTipoEntidad,'placeholder'=>'Seleccione un Tipo de Entidad','allowClear'=>true,'column'=>7])
	</div>
	<!-- Coau Observaciones Field -->
	<div class="col-xs-12"> 
		<div class="form-group  {{ $errors->has('COAU_OBSERVACIONES') ? ' has-error' : '' }}">
		    {!! Form::label('COAU_OBSERVACIONES', 'Observaciones:', ['class' => 'control-label Coau Observaciones']) !!}
			{!! Form::textarea('COAU_OBSERVACIONES', null, ['class' => 'form-control ','size' => '20x3','style' => 'resize: vertical']) !!}
			@include('widgets.forms.alerta',['name'=>'COAU_OBSERVACIONES'])
		</div>
	</div>

</div>

<!-- Submit Field 
<div class="form-group col-sm-12">
    {{-- {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!} --}}
</div>-->
