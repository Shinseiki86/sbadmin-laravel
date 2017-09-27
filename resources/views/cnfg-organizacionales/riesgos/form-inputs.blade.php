{{-- @include('datepicker') --}}
{{-- @include('chosen') --}}

@include('widgets.forms.input', ['type'=>'text', 'name'=>'RIES_DESCRIPCION', 'label'=>'Descripción', 'options'=>['maxlength' => '100'] ])

@include('widgets.forms.input', [
	'type'=>'number', 
	'name'=>'RIES_FACTOR', 
	'label'=>'Factor', 
	'options'=>['max' => '10.3','step'=>'0.001'] 
])

@include('widgets.forms.input', [ 'type'=>'textarea', 'name'=>'RIES_OBSERVACIONES', 'label'=>'Observaciones', 'options'=>['maxlength' => '300'] ])