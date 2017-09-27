{{--@include('datepicker')--}}
{{--@include('chosen')--}}
@include('chosen')

@include('widgets.forms.input', ['type'=>'text', 'name'=>'TEMP_RAZONSOCIAL', 'label'=>'Razón Social', 'options'=>['maxlength' => '100'] ])

@include('widgets.forms.input', ['type'=>'text', 'name'=>'TEMP_NOMBRECOMERCIAL', 'label'=>'Nombre Comercial', 'options'=>['maxlength' => '100'] ])

@include('widgets.forms.input', ['type'=>'text', 'name'=>'TEMP_DIRECCION', 'label'=>'Dirección', 'options'=>['maxlength' => '100'] ])

@include('widgets.forms.input', ['type'=>'select', 'name'=>'PROS_ID', 'label'=>'Responsable de Gestión Humana', 'data'=>$arrProspectos])

@include('widgets.forms.input', [ 'type'=>'textarea', 'name'=>'TEMP_OBSERVACIONES', 'label'=>'Observaciones', 'options'=>['maxlength' => '300'] ])
