{{--@include('datepicker')--}}
{{--@include('chosen')--}}

@include('widgets.forms.input', ['type'=>'text', 'name'=>'MORE_DESCRIPCION', 'label'=>'Descripción', 'options'=>['maxlength' => '100'] ])

@include('widgets.forms.input', [ 'type'=>'textarea', 'name'=>'MORE_OBSERVACIONES', 'label'=>'Observaciones', 'options'=>['maxlength' => '300'] ])
