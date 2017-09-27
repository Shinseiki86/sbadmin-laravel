{{--@include('datepicker')--}}
@include('chosen')

@include('widgets.forms.input', ['type'=>'text', 'name'=>'PROC_DESCRIPCION', 'label'=>'Descripción', 'options'=>['maxlength' => '100'] ])

@include('widgets.forms.input', ['type'=>'select', 'name'=>'GERE_ids', 'label'=>'Gerencias', 'data'=>$arrGerencias, 'multiple'=>true])

@include('widgets.forms.input', [ 'type'=>'textarea', 'name'=>'PROC_OBSERVACIONES', 'label'=>'Observaciones', 'options'=>['maxlength' => '300'] ])