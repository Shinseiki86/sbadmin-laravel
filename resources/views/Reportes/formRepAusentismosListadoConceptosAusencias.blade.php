<div class="row">
		@include('widgets.forms.input', ['type'=>'select', 'column'=>3, 'name'=>'entidad', 'label'=>'Entidad Responsable', 'ajax'=>['model'=>'TipoEntidad','column'=>'TIEN_DESCRIPCION']])
		@include('widgets.forms.input', ['type'=>'select', 'column'=>3, 'name'=>'concepto', 'label'=>'Concepto de Ausencia', 'ajax'=>['model'=>'ConceptoAusencia','column'=>'COAU_DESCRIPCION']])
</div>

