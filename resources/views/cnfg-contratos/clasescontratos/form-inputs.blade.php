{{--@include('datepicker')--}}
{{--@include('chosen')--}}
<div class='col-md-8 col-md-offset-2'>

@include('widgets.forms.input', ['type'=>'text', 'name'=>'CLCO_DESCRIPCION', 'label'=>'Descripción', 'options'=>['maxlength' => '100'] ])

@include('widgets.forms.input', [ 'type'=>'textarea', 'name'=>'CLCO_OBSERVACIONES', 'label'=>'Observaciones', 'options'=>['maxlength' => '300'] ])

</div>