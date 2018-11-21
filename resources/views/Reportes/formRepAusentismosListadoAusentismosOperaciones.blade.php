<div class="row">
	<div class="col-xs-12 col-sm-6">
		@include('widgets.forms.input', ['type'=>'select', 'column'=>6, 'name'=>'empresa', 'label'=>'Empresa', 'ajax'=>['model'=>'Empleador','column'=>'EMPL_NOMBRECOMERCIAL']])
		@include('widgets.forms.input', ['type'=>'select', 'column'=>6, 'name'=>'gerencia', 'label'=>'Gerencia', 'ajax'=>['model'=>'Gerencia','column'=>'GERE_DESCRIPCION']])
	</div>

	<div class="col-xs-12 col-sm-6">
		@include('widgets.forms.input', ['type'=>'select', 'column'=>6, 'name'=>'centrocosto', 'label'=>'Centro de Costo', 'ajax'=>['model'=>'CentroCosto','column'=>'CECO_DESCRIPCION']])
		@include('widgets.forms.input', ['type'=>'select', 'column'=>6, 'name'=>'temporal', 'label'=>'Temporal',  'ajax'=>['model'=>'Temporal','column'=>'TEMP_NOMBRECOMERCIAL']])
	</div>
</div>

<div class="row">
	<div class="col-xs-12 col-sm-6">
		@include('widgets.forms.input', ['type'=>'select', 'column'=>12, 'name'=>'cargo', 'label'=>'Cargo', 'ajax'=>['model'=>'Cargo','column'=>'CARG_DESCRIPCION']])
	</div>
	<div class="col-xs-12 col-sm-6">
		@include('widgets.forms.input', ['type'=>'select', 'column'=>6, 'name'=>'periodo', 'label'=>'Periodo', 'ajax'=>['model'=>'PeriodoNomina','column'=>'PENO_DESCRIPCION'], 'placeholder'=>'Seleccione...','allowClear'=>true])
		@include('widgets.forms.input', ['type'=>'select', 'column'=>6, 'name'=>'tipo', 'label'=>'Tipo de Ausentismo', 'ajax'=>['model'=>'TipoAusentismo','column'=>'TIAU_DESCRIPCION']])
	</div>
</div>

<div class="row">
	<div class="col-xs-12 col-sm-6">
		@include('widgets.forms.input', ['type'=>'select', 'column'=>12, 'name'=>'concepto', 'label'=>'Concepto', 'ajax'=>['model'=>'ConceptoAusencia','column'=>'COAU_DESCRIPCION']])
	</div>

	<div class="col-xs-6 col-sm-6">
	@include('widgets.forms.input', ['type'=>'date', 'column'=>6, 'name'=>'fchaGrabacionDesde', 'label'=>'Fecha grabación desde' ])
	@include('widgets.forms.input', ['type'=>'date', 'column'=>6, 'name'=>'fchaGrabacionHasta', 'label'=>'Fecha grabación hasta' ])
	</div>

	<div class="col-xs-12 col-sm-12">
		@include('widgets.forms.input', [ 'type'=>'select', 'column'=>6, 'name'=>'prospecto', 'label'=>'Empleado', 'ajax'=>['url'=>'gestion-humana/getArrProspectosRetirados']])
	</div>

</div>

