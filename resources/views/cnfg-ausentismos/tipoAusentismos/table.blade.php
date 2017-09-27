<table class="table table-striped" id="tabla">
    <thead>
        <th>Codigo</th>
		<th>Descripcion</th>
		<th>Observaciones</th>
        <th class="col-md-1 all" width="50px">Acciones</th>
    </thead>
    <tbody>
    @foreach($tipoausentismos as $tipoausentismo)
        <tr>
            <td>{!! $tipoausentismo->TIAU_CODIGO !!}</td>
			<td>{!! $tipoausentismo->TIAU_DESCRIPCION !!}</td>
			<td>{!! $tipoausentismo->TIAU_OBSERVACIONES !!}</td>
             <td>
                <!-- Botón Editar (edit) -->
                <a class="btn btn-small btn-info btn-xs" href="{{ route('cnfg-ausentismos.tipoausentismos.edit', [ $tipoausentismo->TIAU_ID ] ) }}" data-tooltip="tooltip" title="Editar">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                </a>

                <!-- carga botón de borrar -->
                {{ Form::button('<i class="fa fa-trash" aria-hidden="true"></i>',[
                    'class'=>'btn btn-xs btn-danger btn-delete',
                    'data-toggle'=>'modal',
                    'data-id'=> $tipoausentismo->TIAU_ID,
                    'data-modelo'=> str_upperspace(class_basename($tipoausentismo)),
                    'data-descripcion'=> $tipoausentismo->TIAU_NOMBRE,
                    'data-action'=>'tipoausentismos/'. $tipoausentismo->TIAU_ID,
                    'data-target'=>'#pregModalDelete',
                    'data-tooltip'=>'tooltip',
                    'title'=>'Borrar',
                ])}}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>