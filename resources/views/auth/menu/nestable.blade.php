@push('head')
	<meta name="csrf-token" content="{{ csrf_token() }}">
	{!! Html::style('assets/stylesheets/nestable.css') !!}
@endpush

@push('scripts')
	{{ Html::script('assets/scripts/jquery/jquery.nestable.js') }}
	<script type="text/javascript">
	$(function() {
		var csrfToken = $('meta[name="csrf-token"]').attr('content');

		$('.dd').nestable({
			maxDepth: 2,
			dropCallback: function(details) {
				
				var order = new Array();
				$("li[data-id='"+details.destId +"']").find('ol:first').children().each(function(index,elem) {
					order[index] = $(elem).attr('data-id');
				});


				if (order.length === 0){
					var rootOrder = new Array();
					details.destRoot.find('ol > li').each(function(index,elem) {
						rootOrder[index] = $(elem).attr('data-id');
					});
				}
				
				$.ajax({
					url: '{{url("auth/menu/reorder")}}',
					data: {
						source:      details.sourceId, 
						destination: details.destId, 
						order:       JSON.stringify(order),
						rootOrder:   JSON.stringify(rootOrder),
						position:    details.destRoot.attr('data-position')
					},
					dataType: 'json',
					type:     'POST',
					headers: {'X-CSRF-TOKEN': csrfToken}
				})
				.done(function( data, textStatus, jqXHR ) {
					//console.log('Response: '+JSON.stringify(textStatus));
					//$('#response').html(JSON.stringify(response));
					$( "#success-indicator" ).fadeIn(100).delay(1000).fadeOut();
				})
				.fail(function( jqXHR, textStatus, errorThrown ) {
					//console.log('Err: '+JSON.stringify(jqXHR));
					//$('#response').html(event.responseText);
				})
				.always(function( data, textStatus, jqXHR ) {
					//console.log('proc: '+i+' de '+cantRows+'('+porcent+'%)');
					if (jqXHR === 'Forbidden') {
						console.log('Error en la conexión con el servidor. Presione F5.');
					}
					if (typeof jqXHR.responseJSON === 'undefined')
						console.log('NetworkError: 500 Internal Server Error.');
					else
						console.log(jqXHR.responseJSON);
				});
			}

		}).nestable('collapseAll');

		$('.delete_toggle').each(function(index,elem) {
			$(elem).click(function(e){
				e.preventDefault();
				$('#postvalue').attr('value',$(elem).attr('rel'));
				$('#deleteModal').modal('toggle');
			});
		});
	});
	</script>
@endpush
