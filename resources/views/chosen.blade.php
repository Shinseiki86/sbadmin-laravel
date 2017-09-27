@push('head')
	{!! Html::style('assets/stylesheets/select2/select2.min.css') !!}
	{!! Html::style('assets/stylesheets/select2/select2-bootstrap.min.css') !!}
@endpush

@push('scripts')
	{!! Html::script('assets/scripts/select2/select2.min.js') !!}
	{!! Html::script('assets/scripts/select2/es.js') !!}

	<script>
		$(function () {
			jQuery('select.readonly option:not(:selected)').attr('disabled',true);
			$('.selectpicker').select2({
				theme: "bootstrap"
			});
		});
	</script>
@endpush
