{{--@include('datepicker')--}}
{{-- @include('chosen') --}}

@include('widgets.forms.input', ['type'=>'text', 'name'=>'TIEM_DESCRIPCION', 'label'=>'Descripción', 'options'=>['maxlength' => '100'] ])

@include('widgets.forms.input', [ 'type'=>'textarea', 'name'=>'TIEM_OBSERVACIONES', 'label'=>'Observaciones', 'options'=>['maxlength' => '300'] ])