{{ Form::select(
	isset($multiple) && $multiple ?$name.'[]':$name,
	(isset($multiple) && $multiple ? []:[''=>'']) + (isset($data)?$data:[]) , 
	isset($value)? $value:old($name),
	[
		'id'=>$name,
		'class'=>'form-control selectpicker '.(!isset($class)?:$class),
		'data-allow-clear'=>isset($allowClear) && $allowClear ?'true':'false',
		'data-placeholder'=>isset($placeholder) ?$placeholder:'Seleccione una opción',
	] + 
	(isset($options)?$options:[]) +
	(isset($multiple) && $multiple ? ['multiple']:[]) +
	(isset($allowNew) && $allowNew ? ['data-tags'=>'true', 'data-select-on-close'=>'true']:[])
) }}

@if(is_array(old($name)) or isset(${$name}))
@push('scripts')
<script type="text/javascript">
	$('#{{$name}}')
		.val(
			{{ ((old($name)!=null or old($name)!='') and is_array(old($name)))
				? json_encode(array_map('intval', old($name)))
				: (isset(${$name})?''.${$name}:'')
			}}
		);
</script>
@endpush
@endif