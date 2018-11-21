<div class="row">
	<div class="col-xs-12 col-sm-6">
		@include('widgets.forms.input', ['type'=>'text', 'column'=>3, 'name'=>'anio', 'label'=>'Año', 'options'=>['required'] ])
		@include('widgets.forms.input', ['type'=>'select', 'column'=>3, 'name'=>'mes', 'label'=>'Mes', 'ajax'=>['model'=>'Periodo','column'=>'PERI_DESCRIPCION'], 'options'=>['required']])
	</div>
</div>








