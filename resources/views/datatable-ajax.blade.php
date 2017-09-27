@push('head')
	{!! Html::style('assets/stylesheets/datatable/buttons.dataTables.min.css') !!}
	{!! Html::style('assets/stylesheets/datatable/responsive.dataTables.min.css') !!}
	{!! Html::style('assets/stylesheets/datatable/buttons.bootstrap4.min.css') !!}
	{!! Html::style('assets/stylesheets/datatable/dataTables.bootstrap4.min.css') !!}
	{!! Html::style('assets/stylesheets/datatable/responsive.bootstrap.min.css') !!}
@endpush

@push('scripts')
	{!! Html::script('assets/scripts/datatable/jquery.dataTables.min.js') !!}
	{!! Html::script('assets/scripts/datatable/dataTables.buttons.min.js') !!}
	{!! Html::script('assets/scripts/datatable/dataTables.responsive.min.js') !!}
	{!! Html::script('assets/scripts/datatable/buttons.bootstrap4.min.js') !!}
	{!! Html::script('assets/scripts/datatable/dataTables.bootstrap4.min.js') !!}
	{!! Html::script('assets/scripts/datatable/responsive.bootstrap.min.js') !!}

	<script>
		$(document).ready(function(){
			$('#tabla').DataTable({
				processing: true,
				serverSide: true,
				ajax: '{{$urlAjax}}',
				pagingType: 'simple_numbers',
				lengthMenu: [[5,10,25,50,-1], [5,10,25,50,'Todos']],
				bScrollCollapse: true,
				sScrollY: '350px',
				rowReorder: false,
				columns: [
				@foreach($columns as $col)
					{data:'{{$col}}'},
				@endforeach
					{data:'action', orderable: false, searchable: false}
				],
				responsive: true,
				language: { 
					sProcessing:     'Procesando...', 
					sLengthMenu:     'Mostrar _MENU_ registros', 
					sZeroRecords:    'No se encontraron resultados', 
					sEmptyTable:     'Ningún dato disponible en esta tabla', 
					sInfo:           'Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros', 
					sInfoEmpty:      'Mostrando registros del 0 al 0 de un total de 0 registros', 
					sInfoFiltered:   '(filtrado de un total de _MAX_ registros)', 
					sSearch:         'Buscar:', 
					sInfoThousands:  ',', 
					sLoadingRecords: 'Cargando...', 
					oPaginate: { 
						sFirst:    '<i class="fa fa-angle-double-left" aria-hidden="true"></i>',
						sLast:     '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
						sNext:     '<i class="fa fa-chevron-right" aria-hidden="true"></i>',
						sPrevious: '<i class="fa fa-chevron-left" aria-hidden="true"></i>'
					} 
				},
				drawCallback : function(settings) {
					//Carga de datos a mensajes modales para eliminar registros	
					$('.btn-delete').on('click', function(event){
						var modal = $('#pregModalDelete');
						var button = $(event.currentTarget); // Button that triggered the modal
						var id = button.data('id'); // Se obtiene valor en data-id
						modal.find('.id').text(id); //Se asigna en la etiqueta con clase id

						var modelo = button.data('modelo');
						modal.find('.modelo').html(modelo);

						var descripcion = button.data('descripcion');
						modal.find('.descripcion').html(descripcion);

						var urlForm = button.data('action'); // Se cambia acción del formulario.
						modal.find('.frmModal').attr('action', urlForm);
					});
					//Muestra Tooltips de boostrap
					tooltips = $('[data-tooltip="tooltip"]');
					if(tooltips.length > 0)
						tooltips.tooltip();
			  	}
			});
		});
	</script>
@endpush
