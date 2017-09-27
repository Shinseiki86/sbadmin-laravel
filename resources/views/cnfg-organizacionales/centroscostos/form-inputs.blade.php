{{--@include('datepicker')--}}
@include('chosen')
<div class='col-md-8 col-md-offset-2'>

	@include('widgets.forms.input', ['type'=>'text', 'name'=>'CECO_CODIGO', 'label'=>'Código', 'options'=>['maxlength' => '100'] ])

	@include('widgets.forms.input', ['type'=>'text', 'name'=>'CECO_DESCRIPCION', 'label'=>'Descripción', 'options'=>['maxlength' => '100'] ])

	@include('widgets.forms.input', [ 'type'=>'textarea', 'name'=>'CECO_OBSERVACIONES', 'label'=>'Observaciones', 'options'=>['maxlength' => '300'] ])

	<!-- Botones -->
	@include('widgets.forms.buttons', ['url' => 'cnfg-organizacionales/centroscostos'])

</div>