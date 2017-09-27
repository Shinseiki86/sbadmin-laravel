{{--@include('datepicker')--}}
@include('chosen')
<div class='col-md-8 col-md-offset-2'>

	@include('widgets.forms.input', ['type'=>'text', 'name'=>'CARG_DESCRIPCION', 'label'=>'Descripción', 'options'=>['maxlength' => '100'] ])

	@include('widgets.forms.input', ['type'=>'select', 'name'=>'CNOS_ID', 'label'=>'C.N.O', 'data'=>$arrCnos])

	@include('widgets.forms.input', [ 'type'=>'textarea', 'name'=>'CARG_OBSERVACIONES', 'label'=>'Observaciones', 'options'=>['maxlength' => '300'] ])

	<!-- Botones -->
	@include('widgets.forms.buttons', ['url' => 'cnfg-contratos/cargos'])

</div>
