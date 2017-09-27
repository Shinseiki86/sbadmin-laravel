
@push('scripts')  
  	<script>
   		@foreach($columns as $col =>$value)	
			$("#{{$col}}").val('{{ $value }}');	
		@endforeach
	</script> 
@endpush