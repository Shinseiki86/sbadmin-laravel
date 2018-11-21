<div class="row">
		@include('widgets.forms.input', ['type'=>'select', 'column'=>3, 'name'=>'empresa', 'label'=>'Empresa', 'ajax'=>['model'=>'Empleador','column'=>'EMPL_NOMBRECOMERCIAL']])
		@include('widgets.forms.input', ['type'=>'select', 'column'=>3, 'name'=>'gerencia', 'label'=>'Gerencia', 'ajax'=>['model'=>'Gerencia','column'=>'GERE_DESCRIPCION']])
		@include('widgets.forms.input', ['type'=>'select', 'column'=>3, 'name'=>'grupo', 'label'=>'Grupo', 'ajax'=>['model'=>'Grupo','column'=>'GRUP_DESCRIPCION']])
		@include('widgets.forms.input', ['type'=>'select', 'column'=>3, 'name'=>'turno', 'label'=>'Turno', 'ajax'=>['model'=>'Turno','column'=>'TURN_DESCRIPCION']])
</div>

<div class="row">
	@include('widgets.forms.input', ['type'=>'select', 'column'=>3, 'name'=>'cargo', 'label'=>'Cargo', 'ajax'=>['model'=>'Cargo','column'=>'CARG_DESCRIPCION']])
</div>