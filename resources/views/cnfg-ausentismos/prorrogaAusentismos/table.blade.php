<table class="table table-striped" id="tabla">
    <thead>
        <th>Id Ausentismo</th>
		<th>Diagnostico</th>
		<th>Consepto Ausentismo</th>
		<th>Fecha Inicio Prorroga</th>
		<th>Fecha Final Prorroga</th>
		<th>Dias de Prorroga</th>
		<th>Observaciones</th>
        <th class="col-md-1 all" width="50px">Acciones</th>
    </thead>
    <tbody>
    @foreach($prorrogaAusentismos as $prorrogaAusentismo)
        <tr>
            <td>{!! $prorrogaAusentismo->AUSE_ID !!}</td>
			<td>{!! $prorrogaAusentismo->DIAG_ID !!}</td>
			<td>{!! $prorrogaAusentismo->COAU_ID !!}</td>
			<td>{!! $prorrogaAusentismo->PROR_FECHAINICIO !!}</td>
			<td>{!! $prorrogaAusentismo->PROR_FECHAFINAL !!}</td>
			<td>{!! $prorrogaAusentismo->PROR_DIAS !!}</td>
			<td>{!! $prorrogaAusentismo->PROR_OBSERVACIONES !!}</td>
             <td>
                <!-- Botón Editar (edit) -->
                <a class="btn btn-small btn-info btn-xs" href="{{ route('cnfg-ausentismos.prorrogaausentismos.edit', [ $prorrogaAusentismo->PROR_ID ] ) }}" data-tooltip="tooltip" title="Editar">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                </a>

                <!-- carga botón de borrar -->
                {{ Form::button('<i class="fa fa-trash" aria-hidden="true"></i>',[
                    'class'=>'btn btn-xs btn-danger btn-delete',
                    'data-toggle'=>'modal',
                    'data-id'=> $prorrogaAusentismo->PROR_ID,
                    'data-modelo'=> str_upperspace(class_basename($prorrogaAusentismo)),
                    'data-descripcion'=> $prorrogaAusentismo->PROR_NOMBRE,
                    'data-action'=>'prorrogaausentismos/'. $prorrogaAusentismo->PROR_ID,
                    'data-target'=>'#pregModalDelete',
                    'data-tooltip'=>'tooltip',
                    'title'=>'Borrar',
                ])}}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>