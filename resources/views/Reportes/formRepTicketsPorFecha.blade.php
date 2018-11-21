<div class="row">
	<div class="col-xs-6 col-sm-6">
		@include('widgets.forms.input', ['type'=>'date', 'column'=>6, 'name'=>'fchaSolicitudDesde', 'label'=>'Fecha Solicitud desde' ])
		@include('widgets.forms.input', ['type'=>'date', 'column'=>6, 'name'=>'fchaSolicitudHasta', 'label'=>'Fecha Solicitud hasta' ])
	</div>
	<div class="col-xs-6 col-sm-6">
		@include('widgets.forms.input', ['type'=>'select', 'column'=>6, 'name'=>'estado', 'label'=>'Estado Ticket', 'ajax'=>['model'=>'EstadoTicket','column'=>'ESTI_DESCRIPCION'] ])
		@include('widgets.forms.input', ['type'=>'select', 'column'=>6, 'name'=>'estadoaprob', 'label'=>'Estado Aprobación', 'ajax'=>['model'=>'EstadoAprobacion','column'=>'ESAP_DESCRIPCION'] ])
	</div>
</div>

<div class="row">
	<div class="col-xs-6 col-sm-6">
		@include('widgets.forms.input', ['type'=>'select', 'column'=>6, 'name'=>'prioridad', 'label'=>'Prioridad', 'ajax'=>['model'=>'Prioridad','column'=>'PRIO_DESCRIPCION'] ])
		@include('widgets.forms.input', ['type'=>'select', 'column'=>6, 'name'=>'categoria', 'label'=>'Categoría', 'ajax'=>['model'=>'Categoria','column'=>'CATE_DESCRIPCION'] ])
	</div>
	<div class="col-xs-6 col-sm-6">
		@include('widgets.forms.input', ['type'=>'select', 'column'=>6, 'name'=>'tipoincidente', 'label'=>'Tipo de Incidente', 'ajax'=>['model'=>'TipoIncidente','column'=>'TIIN_DESCRIPCION'] ])
		@include('widgets.forms.input', ['type'=>'select', 'column'=>6, 'name'=>'sancion', 'label'=>'Decisión Administrativa', 'ajax'=>['model'=>'Sancion','column'=>'SANC_DESCRIPCION'] ])
	</div>
</div>

<div class="row">
	<div class="col-xs-6 col-sm-6">
		@include('widgets.forms.input', ['type'=>'select', 'column'=>6, 'name'=>'grupo', 'label'=>'Grupo', 'ajax'=>['model'=>'Grupo','column'=>'GRUP_DESCRIPCION'] ])
		@include('widgets.forms.input', ['type'=>'select', 'column'=>6, 'name'=>'turno', 'label'=>'Turno', 'ajax'=>['model'=>'Turno','column'=>'TURN_DESCRIPCION'] ])
	</div>
	<div class="col-xs-6 col-sm-6">
		@include('widgets.forms.input', ['type'=>'date', 'column'=>6, 'name'=>'fchaAprobDesde', 'label'=>'Fecha Aprobación desde' ])
		@include('widgets.forms.input', ['type'=>'date', 'column'=>6, 'name'=>'fchaAprobDesde', 'label'=>'Fecha Aprobación hasta' ])
	</div>
</div>

<div class="row">
	<div class="col-xs-6 col-sm-6">
		@include('widgets.forms.input', ['type'=>'date', 'column'=>6, 'name'=>'fchaCierrebDesde', 'label'=>'Fecha Cierre desde' ])
		@include('widgets.forms.input', ['type'=>'date', 'column'=>6, 'name'=>'fchaCierreHasta', 'label'=>'Fecha Cierre hasta' ])
	</div>
	<div class="col-xs-6 col-sm-6">
		@include('widgets.forms.input', ['type'=>'select', 'column'=>6, 'name'=>'tipocontrato', 'label'=>'Tipo de Contrato', 'ajax'=>['model'=>'TipoContrato','column'=>'TICO_DESCRIPCION'] ])

		@include('widgets.forms.input', [ 'type'=>'select', 'column'=>6, 'name'=>'prospecto', 'label'=>'Empleado', 'ajax'=>['url'=>'gestion-humana/getArrProspectosRetirados']])
	</div>
	
</div>