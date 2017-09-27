{{--@include('datepicker')--}}
@include('chosen')

@include('widgets.forms.input', ['type'=>'select', 'name'=>'EMPL_ID', 'label'=>'Empleador', 'data'=>$arrEmpleadores])

@include('widgets.forms.input', ['type'=>'select', 'name'=>'GERE_ID', 'label'=>'Gerencia', 'data'=>$arrGerencias])

@include('widgets.forms.input', ['type'=>'select', 'name'=>'CARG_ID', 'label'=>'Cargo', 'data'=>$arrCargos])

@include('widgets.forms.input', ['type'=>'number', 'name'=>'PALA_CANTIDAD', 'label'=>'Cantidad Autorizada', 'options'=>['size' => '99999' ] ])
