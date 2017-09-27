{{--@include('datepicker')--}}
@include('chosen')

@include('widgets.forms.input', ['type'=>'text', 'name'=>'GRUP_DESCRIPCION', 'label'=>'Descripción', 'options'=>['maxlength' => '100'] ])

@include('widgets.forms.input', [ 'type'=>'textarea', 'name'=>'GRUP_OBSERVACIONES', 'label'=>'Observaciones', 'options'=>['maxlength' => '300'] ])

	