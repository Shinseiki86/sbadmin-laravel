<?php
namespace App\Http\Controllers\Reportes;
use App\Http\Controllers\Controller;

use \Carbon\Carbon;

use App\Models\Ticket;
use App\Models\EstadoTicket;

class RptTicketsController extends ReporteController
{

	public function __construct()
	{
		parent::__construct();
	}


	private function getQuery()
	{
		$query = Ticket::leftJoin('users', 'users.id', '=', 'TICKETS.USER_ID')
			->leftJoin('SANCIONES', 'SANCIONES.SANC_ID', '=', 'TICKETS.SANC_ID')
			->leftJoin('TURNOS', 'TURNOS.TURN_ID', '=', 'TICKETS.TURN_ID')
			->leftJoin('GRUPOS', 'GRUPOS.GRUP_ID', '=', 'TICKETS.GRUP_ID')
			->join('CONTRATOS', 'CONTRATOS.CONT_ID', '=', 'TICKETS.CONT_ID')
			->join('EMPLEADORES', 'EMPLEADORES.EMPL_ID', '=', 'CONTRATOS.EMPL_ID')
			->join('GERENCIAS', 'GERENCIAS.GERE_ID', '=', 'CONTRATOS.GERE_ID')
			->join('CARGOS', 'CARGOS.CARG_ID', '=', 'CONTRATOS.CARG_ID')
			->join('TIPOSCONTRATOS', 'TIPOSCONTRATOS.TICO_ID', '=', 'CONTRATOS.TICO_ID')
			->join('PROSPECTOS AS PROSP', 'EMPLEADORES.EMPL_ID', '=', 'PROSP.PROS_ID')
			->join('PROSPECTOS', 'PROSPECTOS.PROS_ID', '=', 'CONTRATOS.PROS_ID')
			->join('ESTADOSTICKETS', 'ESTADOSTICKETS.ESTI_ID', '=', 'TICKETS.ESTI_ID')
			->join('ESTADOSAPROBACIONES', 'ESTADOSAPROBACIONES.ESAP_ID', '=', 'TICKETS.ESAP_ID')
			->join('PRIORIDADES', 'PRIORIDADES.PRIO_ID', '=', 'TICKETS.PRIO_ID')
			->join('CATEGORIAS', 'CATEGORIAS.CATE_ID', '=', 'TICKETS.CATE_ID')
			->join('TIPOSINCIDENTES', 'TIPOSINCIDENTES.TIIN_ID', '=', 'TICKETS.CATE_ID')
			->leftJoin('TEMPORALES', 'TEMPORALES.TEMP_ID', '=', 'CONTRATOS.TEMP_ID')
			->leftJoin('PROSPECTOS AS PROS', 'TEMPORALES.PROS_ID', '=', 'PROS.PROS_ID')
			->select([
				'TICK_ID as CODIGO_TICKET',
				'EMPLEADORES.EMPL_NOMBRECOMERCIAL AS EMPRESA',
				'TEMPORALES.TEMP_NOMBRECOMERCIAL AS TEMPORAL',
				'GERENCIAS.GERE_DESCRIPCION AS GERENCIA',
				'TICO_DESCRIPCION AS TIPO_CONTRATO',
				expression_concat([
					'PROS_PRIMERAPELLIDO',
					'PROS_SEGUNDOAPELLIDO',
					'PROS_PRIMERNOMBRE',
					'PROS_SEGUNDONOMBRE'
				], 'NOMBRE_EMPLEADO', 'PROSPECTOS'),
				'CARG_DESCRIPCION AS CARGO',
				'TICK_DESCRIPCION as DESCRIPCION',
				'ESTI_DESCRIPCION as ESTADO',
				'PRIO_DESCRIPCION AS PRIORIDAD',
				'CATE_DESCRIPCION AS CATEGORIA',
				'TIIN_DESCRIPCION AS TIPO_INCIDENTE',
				'TURN_DESCRIPCION AS TURNO',
				'GRUP_DESCRIPCION AS GRUPO',
				'ESAP_DESCRIPCION AS ESTADO_APROBACION',
				expression_concat([
					'PROS_PRIMERAPELLIDO',
					'PROS_SEGUNDOAPELLIDO',
					'PROS_PRIMERNOMBRE',
					'PROS_SEGUNDONOMBRE'
				], 'RESPONSABLE_EST', 'PROS'),
				expression_concat([
					'PROS_PRIMERAPELLIDO',
					'PROS_SEGUNDOAPELLIDO',
					'PROS_PRIMERNOMBRE',
					'PROS_SEGUNDONOMBRE'
				], 'RESPONSABLE_GH', 'PROSP'),
				'TICK_FECHACREADO as FECHA_SOLICITUD',
				'TICK_FECHAAPROBACION as FECHA_EVENTO',
				'TICK_FECHAAPROBACION AS FECHA_APROBACION',
				'TICK_FECHACIERRE AS FECHA_CIERE',
				'TICK_MOTIVORECHAZO AS MOTIVO_RECHAZO',
				'SANC_DESCRIPCION AS DECISION_ADMINISTRATIVA',
				'TICK_CONCLUSION AS CONCLUSION',
				'TICK_OBSERVACIONES AS OBSERVACIONES',
				'TICK_CREADOPOR AS CREADO_POR'
			])
			->whereNull('TICKETS.TICK_FECHAELIMINADO')
			->whereNull('CONTRATOS.CONT_FECHAELIMINADO');

		//hace la consulta con base en los permisos asignados
		$query = get_permisosgenerales(\Auth::user()->id, $query);

		return $query;
	}


	/**
	 * 
	 *
	 * @return Json
	 */
	public function ticketsPorFecha()
	{
		$query = $this->getQuery();
			//->whereIn('TICKETS.ESTI_ID', [EstadoTicket::ABIERTO, EstadoTicket::REASIGNADO]);

		if(isset($this->data['fchaSolicitudDesde']))
			$query->whereDate('TICK_FECHASOLICITUD', '>=', Carbon::parse($this->data['fchaSolicitudDesde']));
		if(isset($this->data['fchaSolicitudHasta']))
			$query->whereDate('TICK_FECHASOLICITUD', '<=', Carbon::parse($this->data['fchaSolicitudHasta']));
		if(isset($this->data['fchaAprobDesde']))
			$query->whereDate('TICK_FECHAAPROBACION', '>=', Carbon::parse($this->data['fchaAprobDesde']));
		if(isset($this->data['fchaAprobHasta']))
			$query->whereDate('TICK_FECHAAPROBACION', '<=', Carbon::parse($this->data['fchaAprobHasta']));
		if(isset($this->data['fchaCierreDesde']))
			$query->whereDate('TICK_FECHACIERRE', '>=', Carbon::parse($this->data['fchaCierrebDesde']));
		if(isset($this->data['fchaCierreHasta']))
			$query->whereDate('TICK_FECHACIERRE', '<=', Carbon::parse($this->data['fchaCierreHasta']));


		if(isset($this->data['estado']))
			$query->where('TICKETS.ESTI_ID', '=', $this->data['estado']);
		if(isset($this->data['estadoaprob']))
			$query->where('TICKETS.ESAP_ID', '=', $this->data['estadoaprob']);
		if(isset($this->data['prioridad']))
			$query->where('TICKETS.PRIO_ID', '=', $this->data['prioridad']);
		if(isset($this->data['categoria']))
			$query->where('TICKETS.CATE_ID', '=', $this->data['categoria']);
		if(isset($this->data['tipoincidente']))
			$query->where('TICKETS.TIIN_ID', '=', $this->data['tipoincidente']);
		if(isset($this->data['sancion']))
			$query->where('TICKETS.SANC_ID', '=', $this->data['sancion']);
		if(isset($this->data['grupo']))
			$query->where('TICKETS.GRUP_ID', '=', $this->data['grupo']);
		if(isset($this->data['turno']))
			$query->where('TICKETS.TURN_ID', '=', $this->data['turno']);
		if(isset($this->data['prospecto']))
			$query->where('PROSPECTOS.PROS_ID', '=', $this->data['prospecto']);
		if(isset($this->data['tipocontrato']))
			$query->where('CONTRATOS.TICO_ID', '=', $this->data['tipocontrato']);


		return $this->buildJson($query, $columnChart='Estado');
	}




}