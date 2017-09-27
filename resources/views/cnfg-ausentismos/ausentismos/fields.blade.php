@include('chosen')
@include('datepicker')
@include('utilidades.autocomplete',['first'=>'DX_DESCRIPCION','ruta'=>'autocomplete','cod'=>'CIE10','id'=>'DIAG_ID'])
@include('utilidades.buscarV',['FieldClave'=>'CIE10','FieldDescripcion'=>'DX_DESCRIPCION','ruta'=>'cnfg-ausentismos/buscaDx','colDescripcion'=>'DIAG_DESCRIPCION','FieldId'=>'DIAG_ID','colId'=>'DIAG_ID'])
<div class='col-md-8 col-md-offset-2'>

	<div class="row">
		@include('widgets.forms.input', ['type'=>'select', 'name'=>'CONT_ID', 'label'=>'Empleado', 'data'=>$arrContratos,'value','placeholder'=>'Seleccione un Prospecto','allowClear'=>true])
		
	</div>

	<!-- Diagnostico -->
	<div class="row">
		{{ Form::hidden('DIAG_ID', null, array('id' => 'DIAG_ID')) }}
		@include('widgets.forms.input', ['type'=>'text', 'column'=>2, 'name'=>'CIE10', 'label'=>'Codigo DX'])
		@include('widgets.forms.input', ['type'=>'text', 'column'=>10, 'name'=>'DX_DESCRIPCION', 'label'=>'Descripcion DX'])
	</div>

	<div class="row">
		@include('widgets.forms.input', ['type'=>'select', 'column'=>6, 'name'=>'COAU_ID', 'label'=>'Concepto de Ausencia', 'data'=>$arrConceptoAusentismo, 'placeholder'=>'Seleccione un Concepto','allowClear'=>true])
		@include('widgets.forms.input', ['type'=>'select', 'column'=>6, 'name'=>'ENTI_ID', 'label'=>'Entidad Responsable', 'data'=>$arrEntidad, 'placeholder'=>'Seleccione una Entidad','allowClear'=>true])
	</div>

	<div class="row">
		@include('widgets.forms.input', ['type'=>'date', 'column'=>4, 'name'=>'AUSE_FECHAINICIO', 'label'=>'Fecha de Inicio' ])
		@include('widgets.forms.input', ['type'=>'date', 'column'=>4, 'name'=>'AUSE_FECHAFINAL', 'label'=>'Fecha Final' ])
		@include('widgets.forms.input', ['type'=>'date', 'column'=>4, 'name'=>'AUSE_FECHAACCIDENTE', 'label'=>'Fecha de Accidente' ])		
	</div>

	<div class="row">
		@include('widgets.forms.input', ['type'=>'number', 'column'=>3, 'name'=>'AUSE_DIAS', 'label'=>'No. de Días'])
		@include('widgets.forms.input', ['type'=>'number', 'column'=>5, 'name'=>'AUSE_IBC', 'label'=>'Ingreso Base de Cotización'])
		@include('widgets.forms.input', ['type'=>'number', 'column'=>4, 'name'=>'AUSE_VALOR', 'label'=>'Valor Total'])
	</div>

	<div class="row">
		<!-- Ause Observaciones Field -->
		@include('widgets.forms.input', [ 'type'=>'textarea', 'name'=>'AUSE_OBSERVACIONES', 'label'=>'Observaciones', 'options'=>['maxlength' => '300'] ])
	</div>

</div>
<!-- Submit Field 
<div class="form-group col-sm-12">
    {{-- {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!} --}}
</div>-->
