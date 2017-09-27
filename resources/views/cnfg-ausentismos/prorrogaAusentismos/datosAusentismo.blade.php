<div class="row">
	<div class="row">
		@include('widgets.forms.input', ['type'=>'select','column'=>6, 'name'=>'CONT_ID', 'label'=>'Prospecto', 'data'=>$arrContratos,'value','placeholder'=>'Seleccione un Prospecto','allowClear'=>true])
		@include('widgets.forms.buttons', ['url' => 'cnfg-ausentismos/prorrogaausentismos'])
	</div>

	<!-- Diagnostico -->
	<div class="row">
		{{ Form::hidden('DIAG_ID', null, array('id' => 'DIAG_ID')) }}
		@include('widgets.forms.input', ['type'=>'text', 'column'=>3, 'name'=>'CIE10', 'label'=>'CIE10'])
		@include('widgets.forms.input', ['type'=>'text', 'column'=>9, 'name'=>'DX_DESCRIPCION', 'label'=>'Descripcion Dx'])
	</div>

	<div class="row">
		@include('widgets.forms.input', ['type'=>'select', 'column'=>6, 'name'=>'COAU_ID', 'label'=>'Concepto Ausencia', 'data'=>$arrConceptoAusentismo, 'placeholder'=>'Seleccione un Concepto','allowClear'=>true])
		@include('widgets.forms.input', ['type'=>'select', 'column'=>6, 'name'=>'ENTI_ID', 'label'=>'Entidad Responsable', 'data'=>$arrEntidad, 'placeholder'=>'Seleccione una Entidad','allowClear'=>true])
	</div>

	<div class="row">
		@include('widgets.forms.input', ['type'=>'date', 'column'=>4, 'name'=>'AUSE_FECHAINICIO', 'label'=>'Fecha de Inicio' ])
		@include('widgets.forms.input', ['type'=>'date', 'column'=>4, 'name'=>'AUSE_FECHAFINAL', 'label'=>'Fecha Final' ])
		@include('widgets.forms.input', ['type'=>'date', 'column'=>4, 'name'=>'AUSE_FECHAACCIDENTE', 'label'=>'Fecha de Accidente' ])		
	</div>

	<div class="row">
		@include('widgets.forms.input', ['type'=>'number', 'column'=>3, 'name'=>'AUSE_DIAS', 'label'=>'Total Dias'])
		@include('widgets.forms.input', ['type'=>'number', 'column'=>5, 'name'=>'AUSE_IBC', 'label'=>'Ingreso Base de Cotizacion'])
		@include('widgets.forms.input', ['type'=>'number', 'column'=>4, 'name'=>'AUSE_VALOR', 'label'=>'VAlor Total'])
	</div>

	<div class="row">
		<!-- Ause Observaciones Field -->
		@include('widgets.forms.input', [ 'type'=>'textarea', 'name'=>'AUSE_OBSERVACIONES', 'label'=>'Observaciones', 'options'=>['maxlength' => '300'] ])
	</div>
</div>