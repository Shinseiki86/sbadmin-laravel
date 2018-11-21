<div class="row">
	@include('widgets.forms.input', [ 'type'=>'select', 'column'=>8, 'name'=>'prospecto', 'label'=>'Empleado', 'ajax'=>['url'=>'gestion-humana/getArrProspectos'] ] )
</div>