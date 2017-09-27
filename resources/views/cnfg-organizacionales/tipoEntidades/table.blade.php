<table class="table table-striped" id="tabla">
    <thead>
        <th>Codigo</th>
		<th>Descripcion</th>
		<th>Observaciones</th>
        <th class="col-md-1 all" width="50px">Acciones</th>
    </thead>
    <tbody>
    @foreach($tipoentidades as $tipoEntidad)
        <tr>
            <td>{!! $tipoEntidad->TIEN_CODIGO !!}</td>
			<td>{!! $tipoEntidad->TIEN_DESCRIPCION !!}</td>
			<td>{!! $tipoEntidad->TIEN_OBSERVACIONES !!}</td>
             <td>
                <!-- Botón Editar (edit) -->
                <a class="btn btn-small btn-info btn-xs" href="{{ route('cnfg-organizacionales.tipoentidades.edit', [ $tipoEntidad->TIEN_ID ] ) }}" data-tooltip="tooltip" title="Editar">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                </a>

                <!-- carga botón de borrar -->
                {{ Form::button('<i class="fa fa-trash" aria-hidden="true"></i>',[
                    'class'=>'btn btn-xs btn-danger btn-delete',
                    'data-toggle'=>'modal',
                    'data-id'=> $tipoEntidad->TIEN_ID,
                    'data-modelo'=> str_upperspace(class_basename($tipoEntidad)),
                    'data-descripcion'=> $tipoEntidad->TIEN_NOMBRE,
                    'data-action'=>'tipoentidades/'. $tipoEntidad->TIEN_ID,
                    'data-target'=>'#pregModalDelete',
                    'data-tooltip'=>'tooltip',
                    'title'=>'Borrar',
                ])}}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>