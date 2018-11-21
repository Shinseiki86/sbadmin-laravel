<div class="row">
	<div class="col-xs-12 col-sm-6">
		@include('widgets.forms.input', ['type'=>'select', 'column'=>6, 'name'=>'empresa', 'label'=>'Empresa', 'ajax'=>['model'=>'Empleador','column'=>'EMPL_NOMBRECOMERCIAL'], 'options'=>['required']])
	</div>

</div>

<div class="row">
	<div class="col-xs-12 col-sm-12">
	@include('widgets.forms.input', ['type'=>'date', 'column'=>3, 'name'=>'fchaIngresoDesde', 'label'=>'Fecha Desde', 'options'=>['required'] ])
	@include('widgets.forms.input', ['type'=>'date', 'column'=>3, 'name'=>'fchaIngresoHasta', 'label'=>'Fecha Hasta', 'options'=>['required'] ])
	</div>
</div>






