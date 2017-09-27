{{--@include('datepicker')--}}
 @include('chosen')
@include('select-color')
<div class='col-md-8 col-md-offset-2'>

@include('widgets.forms.input', ['type'=>'text', 'column'=>11, 'name'=>'CATE_DESCRIPCION', 'label'=>'Descripción', 'options'=>['maxlength' => '100'] ])

@include('widgets.forms.input', ['type'=>'color', 'column'=>1, 'name'=>'CATE_COLOR', 'label'=>'Color'])

@include('widgets.forms.input', ['type'=>'select', 'name'=>'PROC_ID', 'label'=>'Proceso', 'data'=>$arrProcesos])

@include('widgets.forms.input', [ 'type'=>'textarea', 'name'=>'CATE_OBSERVACIONES', 'label'=>'Observaciones', 'options'=>['maxlength' => '300'] ])

</div>