<div class="row">
	<div class="col-xs-12 col-sm-12">
	@include('widgets.forms.input', ['type'=>'date', 'column'=>6, 'name'=>'fchaCumpleDesde', 'label'=>'Fecha Desde', 'options'=>['required'] ])
	@include('widgets.forms.input', ['type'=>'date', 'column'=>6, 'name'=>'fchaCumpleHasta', 'label'=>'Fecha Hasta', 'options'=>['required'] ])
	</div>
</div>

<div class="col-xs-6 col-sm-6">
		@include('widgets.forms.input', [ 'type'=>'select', 'column'=>12, 'name'=>'prospecto', 'label'=>'Empleado', 'ajax'=>['url'=>'gestion-humana/getArrProspectosRetirados']])
</div>