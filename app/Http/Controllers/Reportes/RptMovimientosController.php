<?php
namespace App\Http\Controllers\Reportes;
use App\Http\Controllers\Controller;

use \Carbon\Carbon;

use App\Models\Contrato;
use App\Models\EstadoContrato;
use App\Models\TipoContrato;
use App\Models\ClaseContrato;
use App\Models\ParametroGeneral;
use App\Models\MovimientoEmpleado;

class RptMovimientosController extends ReporteController
{

	public function __construct()
	{
		parent::__construct();
	}


	private function getQuery()
	{

		$query = Contrato::leftJoin('TEMPORALES', 'TEMPORALES.TEMP_ID', '=', 'CONTRATOS.TEMP_ID')
			->leftJoin('MOTIVOSRETIROS', 'MOTIVOSRETIROS.MORE_ID', '=', 'CONTRATOS.MORE_ID')
			->leftJoin('PROSPECTOS AS JEFES', 'JEFES.PROS_ID', '=', 'CONTRATOS.JEFE_ID')
			->leftJoin('PROSPECTOS AS REMPLAZOS', 'REMPLAZOS.PROS_ID', '=', 'CONTRATOS.REMP_ID')
			->join('MOVIMIENTOSEMPLEADOS', 'MOVIMIENTOSEMPLEADOS.CONT_ID', '=', 'CONTRATOS.CONT_ID')
			->join('PROSPECTOS', 'PROSPECTOS.PROS_ID', '=', 'CONTRATOS.PROS_ID')		
			->join('EMPLEADORES', 'EMPLEADORES.EMPL_ID', '=', 'CONTRATOS.EMPL_ID')
			->join('TIPOSCONTRATOS', 'TIPOSCONTRATOS.TICO_ID', '=', 'CONTRATOS.TICO_ID')
			->join('CLASESCONTRATOS', 'CLASESCONTRATOS.CLCO_ID', '=', 'CONTRATOS.CLCO_ID')
			->join('CARGOS', 'CARGOS.CARG_ID', '=', 'CONTRATOS.CARG_ID')
			->join('ESTADOSCONTRATOS', 'ESTADOSCONTRATOS.ESCO_ID', '=', 'CONTRATOS.ESCO_ID')
			->join('TIPOSEMPLEADORES', 'TIPOSEMPLEADORES.TIEM_ID', '=', 'CONTRATOS.TIEM_ID')
			->join('RIESGOS', 'RIESGOS.RIES_ID', '=', 'CONTRATOS.RIES_ID')
			->join('GERENCIAS', 'GERENCIAS.GERE_ID', '=', 'CONTRATOS.GERE_ID')
			->join('NEGOCIOS', 'NEGOCIOS.NEGO_ID', '=', 'CONTRATOS.NEGO_ID')
			->join('CENTROSCOSTOS', 'CENTROSCOSTOS.CECO_ID', '=', 'CONTRATOS.CECO_ID')
			->join('GRUPOS', 'GRUPOS.GRUP_ID', '=', 'MOVIMIENTOSEMPLEADOS.GRUP_ID')
			->join('TURNOS', 'TURNOS.TURN_ID', '=', 'MOVIMIENTOSEMPLEADOS.TURN_ID')
			->join('CIUDADES AS CIUDADES_CONTRATA', 'CIUDADES_CONTRATA.CIUD_ID', '=', 'CONTRATOS.CIUD_CONTRATA')
			->join('CIUDADES AS CIUDADES_SERVICIO', 'CIUDADES_SERVICIO.CIUD_ID', '=', 'CONTRATOS.CIUD_SERVICIO')
			->select([
				'EMPLEADORES.EMPL_NOMBRECOMERCIAL as EMPRESA',
				'TEMPORALES.TEMP_NOMBRECOMERCIAL as E.S.T',
				'PROSPECTOS.PROS_CEDULA as CEDULA',
				expression_concat([
					'PROS_PRIMERAPELLIDO',
					'PROS_SEGUNDOAPELLIDO',
					'PROS_PRIMERNOMBRE',
					'PROS_SEGUNDONOMBRE'
				], 'NOMBRE_EMPLEADO', 'PROSPECTOS'),
				'CARGOS.CARG_DESCRIPCION AS CARGO',
				'ESTADOSCONTRATOS.ESCO_DESCRIPCION AS ESTADO',
				'CONTRATOS.CONT_FECHAINGRESO AS FECHA_INGRESO',
				'GERENCIAS.GERE_DESCRIPCION AS GERENCIA',
				expression_concat([
					'PROS_PRIMERAPELLIDO',
					'PROS_SEGUNDOAPELLIDO',
					'PROS_PRIMERNOMBRE',
					'PROS_SEGUNDONOMBRE'
				], 'JEFE_INMEDIATO', 'JEFES'),
				'GRUPOS.GRUP_DESCRIPCION AS GRUPO',
				'TURNOS.TURN_CODIGO AS TURNO_CODIGO',
				'TURNOS.TURN_DESCRIPCION AS TURNO',
				'MOVIMIENTOSEMPLEADOS.MOEM_FECHADESDE AS FECHA',
			])
			->whereNull('CONTRATOS.CONT_FECHAELIMINADO')
			->whereNull('MOVIMIENTOSEMPLEADOS.MOEM_FECHAELIMINADO');


		//hace la consulta con base en los permisos asignados
		$query = get_permisosgenerales(\Auth::user()->id, $query, 'reporte');

		return $query;
	}

	/**
	 * 
	 *
	 * @return Json
	 */
	public function listadoMovimientos()
	{
		$query = $this->getQuery()
					->whereIn('ESTADOSCONTRATOS.ESCO_ID', [EstadoContrato::ACTIVO, EstadoContrato::VACACIONES, EstadoContrato::RETIRADO]);

		if(isset($this->data['fchaDesde']))
			$query->whereDate('ASEM_FECHA', '>=', Carbon::parse($this->data['fchaDesde']));
		if(isset($this->data['fchaHasta']))
			$query->whereDate('ASEM_FECHA', '<=', Carbon::parse($this->data['fchaHasta']));
		if(isset($this->data['empresa']))
			$query->where('CONTRATOS.EMPL_ID', '=', $this->data['empresa']);
		if(isset($this->data['gerencia']))
			$query->where('CONTRATOS.GERE_ID', '=', $this->data['gerencia']);
		if(isset($this->data['centrocosto']))
			$query->where('CONTRATOS.CECO_ID', '=', $this->data['centrocosto']);
		if(isset($this->data['temporal']))
			$query->where('CONTRATOS.TEMP_ID', '=', $this->data['temporal']);
		if(isset($this->data['cargo']))
			$query->where('CONTRATOS.CARG_ID', '=', $this->data['cargo']);
		if(isset($this->data['grupo']))
			$query->where('MOVIMIENTOSEMPLEADOS.GRUP_ID', '=', $this->data['grupo']);
		if(isset($this->data['turno']))
			$query->where('MOVIMIENTOSEMPLEADOS.TURN_ID', '=', $this->data['turno']);
		if(isset($this->data['prospecto']))
			$query->where('PROSPECTOS.PROS_ID', '=', $this->data['prospecto']);
		if(isset($this->data['negocio']))
			$query->where('CONTRATOS.NEGO_ID', '=', $this->data['negocio']);

		return $this->buildJson($query);
	}


}