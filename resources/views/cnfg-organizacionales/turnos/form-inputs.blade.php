@include('timepicker')
@include('chosen')

@include('widgets.forms.input', ['type'=>'text', 'name'=>'TURN_DESCRIPCION', 'label'=>'Descripción', 'options'=>['maxlength' => '100'] ])

@include('widgets.forms.input', ['type'=>'text', 'name'=>'TURN_CODIGO', 'label'=>'Código', 'options'=>['maxlength' => '10'] ])

@include('widgets.forms.input', ['type'=>'date', 'name'=>'TURN_HORAINICIOPI', 'label'=>'Hora Inicial Primer Intervalo' ])
@include('widgets.forms.input', ['type'=>'date', 'name'=>'TURN_HORAFINALPI', 'label'=>'Hora Final Primer Intervalo' ])

@include('widgets.forms.input', ['type'=>'date', 'name'=>'TURN_HORAINICIOSI', 'label'=>'Hora Inicial Segundo Intervalo' ])
@include('widgets.forms.input', ['type'=>'date', 'name'=>'TURN_HORAFINALSI', 'label'=>'Hora Final Segundo Intervalo' ])

@include('widgets.forms.input', ['type'=>'select', 'name'=>'TURN_TIPOTURNO', 'label'=>'Tipo de Turno', 'data'=>$arrTipoTurnos, 'options'=>['data-live-search'=>'true']])

@include('widgets.forms.input', [ 'type'=>'textarea', 'name'=>'TURN_OBSERVACIONES', 'label'=>'Observaciones', 'options'=>['maxlength' => '300'] ])

