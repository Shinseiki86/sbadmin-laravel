@push('head')
	{!! Html::style('assets/stylesheets/datatable/buttons.dataTables.min.css') !!}
	{!! Html::style('assets/stylesheets/datatable/responsive.dataTables.min.css') !!}
	{!! Html::style('assets/stylesheets/datatable/buttons.bootstrap4.min.css') !!}
	{!! Html::style('assets/stylesheets/datatable/dataTables.bootstrap4.min.css') !!}
	{!! Html::style('assets/stylesheets/datatable/rowReorder.dataTables.min.css') !!}
	{!! Html::style('assets/stylesheets/datatable/responsive.bootstrap.min.css') !!}
@endpush

@push('scripts')
	{!! Html::script('assets/scripts/datatable/jquery.dataTables.min.js') !!}
	{!! Html::script('assets/scripts/datatable/dataTables.buttons.min.js') !!}
	{!! Html::script('assets/scripts/datatable/jszip.min.js') !!}
	{!! Html::script('assets/scripts/datatable/pdfmake.min.js') !!}
	{!! Html::script('assets/scripts/datatable/vfs_fonts.js') !!}
	{!! Html::script('assets/scripts/datatable/buttons.html5.min.js') !!}
	{!! Html::script('assets/scripts/datatable/buttons.colVis.min.js') !!}
	{!! Html::script('assets/scripts/datatable/buttons.print.min.js') !!}
	{!! Html::script('assets/scripts/datatable/dataTables.responsive.min.js') !!}
	{!! Html::script('assets/scripts/datatable/buttons.flash.min.js') !!}
	{!! Html::script('assets/scripts/datatable/buttons.bootstrap4.min.js') !!}
	{!! Html::script('assets/scripts/datatable/dataTables.bootstrap4.min.js') !!}
	{!! Html::script('assets/scripts/datatable/dataTables.rowReorder.min.js') !!}
	{!! Html::script('assets/scripts/datatable/responsive.bootstrap.min.js') !!}

	<script>
	 $(function () {
		/*
		para realizar la paginacion de una tabla lo unico que hay que hacer es asignarle un id a la tabla,
		en este caso el id es "tabla" e invocar la función Datatable, lo demas que ven sobre esta función
		son configuraciones de presentación
		HFG--Se Realiza ajuste de texto, otros atributos
		*/
		
		$('.table').DataTable({  
			lengthMenu: [[5,10,25,50,-1], [5,10,25,50,'Todos']],
			pagingType: 'simple_numbers',
			bScrollCollapse: true,
			sScrollY: '500px',
			rowReorder: false,
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
		});
		
		$('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
			$.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust().draw();
		});

	  });
	</script>
@endpush
