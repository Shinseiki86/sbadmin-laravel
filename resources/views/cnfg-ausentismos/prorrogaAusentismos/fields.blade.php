@include('chosen')
@include('datepicker')
@include('utilidades.autocomplete',['first'=>'DX_DESCRIPCION','ruta'=>'autocomplete','cod'=>'CIE10','id'=>'DIAG_ID'])
@include('utilidades.buscarV',['FieldClave'=>'CIE10','FieldDescripcion'=>'DX_DESCRIPCION','ruta'=>'cnfg-ausentismos/buscaDx','colDescripcion'=>'DIAG_DESCRIPCION','FieldId'=>'DIAG_ID','colId'=>'DIAG_ID'])
<div class='col-md-8 col-md-offset-2'>	
	<!-- Ause Id Field -->
	<div class="col-xs-12"> 
		<div class="form-group  {{ $errors->has('AUSE_ID') ? ' has-error' : '' }}">
		    {!! Form::label('AUSE_ID', 'Ause Id:', ['class' => 'control-label Ause Id']) !!}
		{!! Form::number('AUSE_ID', null, ['class' => 'form-control']) !!}
			@include('widgets.forms.alerta',['name'=>'AUSE_ID'])
		</div>
	</div>

	<!-- Diag Id Field -->
	<div class="col-xs-12"> 
		<div class="form-group  {{ $errors->has('DIAG_ID') ? ' has-error' : '' }}">
		    {!! Form::label('DIAG_ID', 'Diag Id:', ['class' => 'control-label Diag Id']) !!}
		{!! Form::number('DIAG_ID', null, ['class' => 'form-control']) !!}
			@include('widgets.forms.alerta',['name'=>'DIAG_ID'])
		</div>
	</div>

	<!-- Coau Id Field -->
	<div class="col-xs-12"> 
		<div class="form-group  {{ $errors->has('COAU_ID') ? ' has-error' : '' }}">
		    {!! Form::label('COAU_ID', 'Coau Id:', ['class' => 'control-label Coau Id']) !!}
		{!! Form::number('COAU_ID', null, ['class' => 'form-control']) !!}
			@include('widgets.forms.alerta',['name'=>'COAU_ID'])
		</div>
	</div>

	<!-- Diagnostico -->
		<div class="row">
			{{ Form::hidden('DIAG_ID', null, array('id' => 'DIAG_ID')) }}
			@include('widgets.forms.input', ['type'=>'text', 'column'=>2, 'name'=>'CIE10', 'label'=>'CIE10'])
			@include('widgets.forms.input', ['type'=>'text', 'column'=>10, 'name'=>'DX_DESCRIPCION', 'label'=>'Descripcion Dx'])
		</div>

		<div class="row">
			@include('widgets.forms.input', ['type'=>'select', 'column'=>6, 'name'=>'COAU_ID', 'label'=>'Concepto Ausencia', 'data'=>$arrConceptoAusentismo, 'placeholder'=>'Seleccione un Concepto','allowClear'=>true])
			@include('widgets.forms.input', ['type'=>'select', 'column'=>6, 'name'=>'ENTI_ID', 'label'=>'Entidad Responsable', 'data'=>$arrEntidad, 'placeholder'=>'Seleccione una Entidad','allowClear'=>true])
		</div>

	<div class="row">
		@include('widgets.forms.input', ['type'=>'date', 'column'=>4, 'name'=>'PROR_FECHAINICIO', 'label'=>'Fecha de Inicio' ])
		@include('widgets.forms.input', ['type'=>'date', 'column'=>4, 'name'=>'PROR_FECHAFINAL', 'label'=>'Fecha Final' ])	
		@include('widgets.forms.input', ['type'=>'number', 'column'=>4, 'name'=>'PROR_DIAS', 'label'=>'Total Dias'])	
	</div>

	<div class="row">
		<!-- Ause Observaciones Field -->
		@include('widgets.forms.input', [ 'type'=>'textarea', 'name'=>'PROR_OBSERVACIONES', 'label'=>'Observaciones', 'options'=>['maxlength' => '300'] ])
	</div>
</div>
<!-- Submit Field 
<div class="form-group col-sm-12">
    {{-- {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!} --}}
</div>-->
