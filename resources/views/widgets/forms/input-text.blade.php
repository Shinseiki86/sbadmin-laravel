{{ Form::text( $name, isset($value)? $value:old($name), ['class'=>'form-control autocomplete'] + (isset($options)?$options:[]) )}}