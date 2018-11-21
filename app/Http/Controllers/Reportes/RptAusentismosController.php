<?php
namespace App\Http\Controllers\Reportes;
use App\Http\Controllers\Controller;

use \Carbon\Carbon;

use App\Models\Contrato;
use App\Models\EstadoContrato;
use App\Models\TipoContrato;
use App\Models\ClaseContrato;
use App\Models\ParametroGeneral;
use App\Models\ConceptoAusencia;

class RptAusentismosController extends ReporteController
{

	public function __construct()
	{
		parent::__construct();
	}

	private function getQueryConceptos()
	{
			$query = ConceptoAusencia::join('TIPOAUSENTISMOS', 'TIPOAUSENTISMOS.TIAU_ID', '=', 'CONCEPTOAUSENCIAS.TIAU_ID')
			->select([
				'COAU_CODIGO AS CODIGO',
				'COAU_DESCRIPCION AS DESCRIPCION',
				'COAU_OBSERVACIONES AS OBSERVACIONES',
				'TIAU_DESCRIPCION AS TIPO_AUSENTISMO',
			])
			->whereNull('CONCEPTOAUSENCIAS.COAU_FECHAELIMINADO');

			return $query;
	}

	/**
	 * 
	 *
	 * @return Json
	 */
	public function listadoConceptosAusencias()
	{
		$query = $this->getQueryConceptos();

		if(isset($this->data['entidad']))
			$query->where('CONCEPTOAUSENCIAS.TIEN_ID', '=', $this->data['entidad']);
		if(isset($this->data['concepto']))
			$query->where('CONCEPTOAUSENCIAS.COAU_ID', '=', $this->data['concepto']);

		return $this->buildJson($query);
	}


	private function getQuery()
	{
		$query = Contrato::leftJoin('TEMPORALES', 'TEMPORALES.TEMP_ID', '=', 'CONTRATOS.TEMP_ID')
			->leftJoin('PROSPECTOS AS JEFES', 'JEFES.PROS_ID', '=', 'CONTRATOS.JEFE_ID')
			->join('PROSPECTOS', 'PROSPECTOS.PROS_ID', '=', 'CONTRATOS.PROS_ID')		
			->join('EMPLEADORES', 'EMPLEADORES.EMPL_ID', '=', 'CONTRATOS.EMPL_ID')
			->join('TIPOSCONTRATOS', 'TIPOSCONTRATOS.TICO_ID', '=', 'CONTRATOS.TICO_ID')
			->join('CARGOS', 'CARGOS.CARG_ID', '=', 'CONTRATOS.CARG_ID')
			->join('ESTADOSCONTRATOS', 'ESTADOSCONTRATOS.ESCO_ID', '=', 'CONTRATOS.ESCO_ID')
			->join('GERENCIAS', 'GERENCIAS.GERE_ID', '=', 'CONTRATOS.GERE_ID')
			->join('NEGOCIOS', 'NEGOCIOS.NEGO_ID', '=', 'CONTRATOS.NEGO_ID')
			->join('CENTROSCOSTOS', 'CENTROSCOSTOS.CECO_ID', '=', 'CONTRATOS.CECO_ID')
			->join('GRUPOS', 'GRUPOS.GRUP_ID', '=', 'CONTRATOS.GRUP_ID')
			->leftJoin('GRUPOS_RESPONSABLES', 'GRUPOS_RESPONSABLES.GRUP_ID', '=', 'GRUPOS.GRUP_ID')
			->leftJoin('PROSPECTOS AS GRUPORESPONSABLE', 'GRUPORESPONSABLE.PROS_ID', '=', 'GRUPOS_RESPONSABLES.PROS_ID')
			->join('TURNOS', 'TURNOS.TURN_ID', '=', 'CONTRATOS.TURN_ID')
			->join('AUSENTISMOS','AUSENTISMOS.CONT_ID', '=', 'CONTRATOS.CONT_ID')
			->join('PERIODOSNOMINAS','PERIODOSNOMINAS.PENO_ID', '=', 'AUSENTISMOS.PENO_ID')
			->join('ENTIDADES','ENTIDADES.ENTI_ID', '=', 'AUSENTISMOS.ENTI_ID')
			->join('CONCEPTOAUSENCIAS','CONCEPTOAUSENCIAS.COAU_ID', '=', 'AUSENTISMOS.COAU_ID')
			->join('TIPOAUSENTISMOS','TIPOAUSENTISMOS.TIAU_ID', '=', 'CONCEPTOAUSENCIAS.TIAU_ID')
			->join('TIPOENTIDADES','TIPOENTIDADES.TIEN_ID', '=', 'CONCEPTOAUSENCIAS.TIEN_ID')
			->leftJoin('DIAGNOSTICOS','DIAGNOSTICOS.DIAG_ID', '=', 'AUSENTISMOS.DIAG_ID')
			->select([
				'AUSENTISMOS.AUSE_ID as CODIGO',
				'EMPLEADORES.EMPL_NOMBRECOMERCIAL as EMPRESA',
				'PROSPECTOS.PROS_CEDULA as CEDULA',
				expression_concat([
					'PROS_PRIMERAPELLIDO',
					'PROS_SEGUNDOAPELLIDO',
					'PROS_PRIMERNOMBRE',
					'PROS_SEGUNDONOMBRE'
				], 'NOMBRE_EMPLEADO', 'PROSPECTOS'),
				'DIAGNOSTICOS.DIAG_CODIGO AS DX',
				'DIAGNOSTICOS.DIAG_DESCRIPCION AS DX_DESCRIPCION',
				'AUSENTISMOS.AUSE_FECHAINICIO AS FECHA_INICIAL',
				'AUSENTISMOS.AUSE_DIAS AS NUM_DIAS',
				'AUSENTISMOS.AUSE_FECHAFINAL AS FECHA_FINAL',
				'TIPOAUSENTISMOS.TIAU_DESCRIPCION AS TIPO_AUSENTISMOS',
				'AUSENTISMOS.AUSE_FECHAACCIDENTE AS FECHA_ACCIDENTE',
				'PERIODOSNOMINAS.PENO_DESCRIPCION AS PERIODO',
				'CONCEPTOAUSENCIAS.COAU_DESCRIPCION AS CONCEPTO_AUSENCIA',
				'GERENCIAS.GERE_DESCRIPCION AS GERENCIA',
				'NEGOCIOS.NEGO_DESCRIPCION AS NEGOCIO',
				'TEMPORALES.TEMP_NOMBRECOMERCIAL as E.S.T',
				'TIPOSCONTRATOS.TICO_DESCRIPCION as TIPO_CONTRATO',
				'CARGOS.CARG_DESCRIPCION AS CARGO',
				'TIPOAUSENTISMOS.TIAU_DESCRIPCION AS TIPO_AUSENTISMO',
				'TIPOENTIDADES.TIEN_DESCRIPCION AS TIPO_ENTIDAD',
				'ENTIDADES.ENTI_RAZONSOCIAL AS ENTIDAD_RESPONSABLE',
				expression_concat([
					'PROS_PRIMERAPELLIDO',
					'PROS_SEGUNDOAPELLIDO',
					'PROS_PRIMERNOMBRE',
					'PROS_SEGUNDONOMBRE'
				], 'JEFE_INMEDIATO', 'JEFES'),
				'GRUPOS.GRUP_DESCRIPCION AS GRUPO_EMPLEADO',
				'TURNOS.TURN_DESCRIPCION AS TURNO_EMPLEADO',
				expression_concat([
					'PROS_PRIMERAPELLIDO',
					'PROS_SEGUNDOAPELLIDO',
					'PROS_PRIMERNOMBRE',
					'PROS_SEGUNDONOMBRE'
				], 'GRUPO_RESPONSABLE', 'GRUPORESPONSABLE'),
			])
			->whereNull('AUSENTISMOS.AUSE_FECHAELIMINADO')
			->whereNull('CONTRATOS.CONT_FECHAELIMINADO');

			//hace la consulta con base en los permisos asignados
			$query = get_permisosgenerales(\Auth::user()->id, $query);

		return $query;
	}

	private function getQueryProrrogas()
	{
		$query = Contrato::leftJoin('TEMPORALES', 'TEMPORALES.TEMP_ID', '=', 'CONTRATOS.TEMP_ID')
			->leftJoin('PROSPECTOS AS JEFES', 'JEFES.PROS_ID', '=', 'CONTRATOS.JEFE_ID')
			->join('PROSPECTOS', 'PROSPECTOS.PROS_ID', '=', 'CONTRATOS.PROS_ID')		
			->join('EMPLEADORES', 'EMPLEADORES.EMPL_ID', '=', 'CONTRATOS.EMPL_ID')
			->join('TIPOSCONTRATOS', 'TIPOSCONTRATOS.TICO_ID', '=', 'CONTRATOS.TICO_ID')
			->join('CARGOS', 'CARGOS.CARG_ID', '=', 'CONTRATOS.CARG_ID')
			->join('ESTADOSCONTRATOS', 'ESTADOSCONTRATOS.ESCO_ID', '=', 'CONTRATOS.ESCO_ID')
			->join('GERENCIAS', 'GERENCIAS.GERE_ID', '=', 'CONTRATOS.GERE_ID')
			->join('NEGOCIOS', 'NEGOCIOS.NEGO_ID', '=', 'CONTRATOS.NEGO_ID')
			->join('CENTROSCOSTOS', 'CENTROSCOSTOS.CECO_ID', '=', 'CONTRATOS.CECO_ID')
			->join('GRUPOS', 'GRUPOS.GRUP_ID', '=', 'CONTRATOS.GRUP_ID')
			->leftJoin('GRUPOS_RESPONSABLES', 'GRUPOS_RESPONSABLES.GRUP_ID', '=', 'GRUPOS.GRUP_ID')
			->leftJoin('PROSPECTOS AS GRUPORESPONSABLE', 'GRUPORESPONSABLE.PROS_ID', '=', 'GRUPOS_RESPONSABLES.PROS_ID')
			->join('TURNOS', 'TURNOS.TURN_ID', '=', 'CONTRATOS.TURN_ID')
			->join('AUSENTISMOS','AUSENTISMOS.CONT_ID', '=', 'CONTRATOS.CONT_ID')
			->join('PERIODOSNOMINAS','PERIODOSNOMINAS.PENO_ID', '=', 'AUSENTISMOS.PENO_ID')
			->join('ENTIDADES','ENTIDADES.ENTI_ID', '=', 'AUSENTISMOS.ENTI_ID')
			->join('CONCEPTOAUSENCIAS','CONCEPTOAUSENCIAS.COAU_ID', '=', 'AUSENTISMOS.COAU_ID')
			->join('TIPOAUSENTISMOS','TIPOAUSENTISMOS.TIAU_ID', '=', 'CONCEPTOAUSENCIAS.TIAU_ID')
			->join('TIPOENTIDADES','TIPOENTIDADES.TIEN_ID', '=', 'CONCEPTOAUSENCIAS.TIEN_ID')
			->join('PRORROGAAUSENTISMOS', 'PRORROGAAUSENTISMOS.AUSE_ID', '=', 'AUSENTISMOS.AUSE_ID')
			->leftJoin('DIAGNOSTICOS','DIAGNOSTICOS.DIAG_ID', '=', 'PRORROGAAUSENTISMOS.DIAG_ID')
			->select([
				'AUSENTISMOS.AUSE_ID as CODIGO_AUS_INICIAL',
				'EMPLEADORES.EMPL_NOMBRECOMERCIAL as EMPRESA',
				'PROSPECTOS.PROS_CEDULA as CEDULA',
				expression_concat([
					'PROS_PRIMERAPELLIDO',
					'PROS_SEGUNDOAPELLIDO',
					'PROS_PRIMERNOMBRE',
					'PROS_SEGUNDONOMBRE'
				], 'NOMBRE_EMPLEADO', 'PROSPECTOS'),
				'DIAGNOSTICOS.DIAG_CODIGO AS DX',
				'DIAGNOSTICOS.DIAG_DESCRIPCION AS DX_DESCRIPCION',
				'PRORROGAAUSENTISMOS.PROR_FECHAINICIO AS FECHA_INICIAL',
				'PRORROGAAUSENTISMOS.PROR_DIAS AS NUMERO_DIAS',
				'PRORROGAAUSENTISMOS.PROR_FECHAFINAL AS FECHA_FINAL',
				'TIPOAUSENTISMOS.TIAU_DESCRIPCION AS TIPO_AUSENTISMOS',
				'PERIODOSNOMINAS.PENO_DESCRIPCION AS PERIODO',
				'CONCEPTOAUSENCIAS.COAU_DESCRIPCION AS CONCEPTO_AUSENCIA',
				'GERENCIAS.GERE_DESCRIPCION AS GERENCIA',
				'NEGOCIOS.NEGO_DESCRIPCION AS NEGOCIO',
				'TEMPORALES.TEMP_NOMBRECOMERCIAL as E.S.T',
				'TIPOSCONTRATOS.TICO_DESCRIPCION as TIPO_CONTRATO',
				'CARGOS.CARG_DESCRIPCION AS CARGO',
				'TIPOAUSENTISMOS.TIAU_DESCRIPCION AS TIPO_AUSENTISMO',
				'TIPOENTIDADES.TIEN_DESCRIPCION AS TIPO_ENTIDAD',
				'ENTIDADES.ENTI_RAZONSOCIAL AS ENTIDAD_RESPONSABLE',
				expression_concat([
					'PROS_PRIMERAPELLIDO',
					'PROS_SEGUNDOAPELLIDO',
					'PROS_PRIMERNOMBRE',
					'PROS_SEGUNDONOMBRE'
				], 'JEFE_INMEDIATO', 'JEFES'),
				'GRUPOS.GRUP_DESCRIPCION AS GRUPO_EMPLEADO',
				'TURNOS.TURN_DESCRIPCION AS TURNO_EMPLEADO',
				expression_concat([
					'PROS_PRIMERAPELLIDO',
					'PROS_SEGUNDOAPELLIDO',
					'PROS_PRIMERNOMBRE',
					'PROS_SEGUNDONOMBRE'
				], 'GRUPO_RESPONSABLE', 'GRUPORESPONSABLE'),
				
			])
			->whereNull('AUSENTISMOS.AUSE_FECHAELIMINADO')
			->whereNull('PRORROGAAUSENTISMOS.PROR_FECHAELIMINADO')
			->whereNull('CONTRATOS.CONT_FECHAELIMINADO');

		//hace la consulta con base en los permisos asignados
		$query = get_permisosgenerales(\Auth::user()->id, $query);

		return $query;
	}

	private function getQueryOperaciones()
	{
		$query = Contrato::leftJoin('TEMPORALES', 'TEMPORALES.TEMP_ID', '=', 'CONTRATOS.TEMP_ID')
			->leftJoin('PROSPECTOS AS JEFES', 'JEFES.PROS_ID', '=', 'CONTRATOS.JEFE_ID')
			->join('PROSPECTOS', 'PROSPECTOS.PROS_ID', '=', 'CONTRATOS.PROS_ID')		
			->join('EMPLEADORES', 'EMPLEADORES.EMPL_ID', '=', 'CONTRATOS.EMPL_ID')
			->join('TIPOSCONTRATOS', 'TIPOSCONTRATOS.TICO_ID', '=', 'CONTRATOS.TICO_ID')
			->join('CARGOS', 'CARGOS.CARG_ID', '=', 'CONTRATOS.CARG_ID')
			->join('ESTADOSCONTRATOS', 'ESTADOSCONTRATOS.ESCO_ID', '=', 'CONTRATOS.ESCO_ID')
			->join('GERENCIAS', 'GERENCIAS.GERE_ID', '=', 'CONTRATOS.GERE_ID')
			->join('NEGOCIOS', 'NEGOCIOS.NEGO_ID', '=', 'CONTRATOS.NEGO_ID')
			->join('CENTROSCOSTOS', 'CENTROSCOSTOS.CECO_ID', '=', 'CONTRATOS.CECO_ID')
			->join('GRUPOS', 'GRUPOS.GRUP_ID', '=', 'CONTRATOS.GRUP_ID')
			->leftJoin('GRUPOS_RESPONSABLES', 'GRUPOS_RESPONSABLES.GRUP_ID', '=', 'GRUPOS.GRUP_ID')
			->leftJoin('PROSPECTOS AS GRUPORESPONSABLE', 'GRUPORESPONSABLE.PROS_ID', '=', 'GRUPOS_RESPONSABLES.PROS_ID')
			->join('TURNOS', 'TURNOS.TURN_ID', '=', 'CONTRATOS.TURN_ID')
			->join('AUSENTISMOS','AUSENTISMOS.CONT_ID', '=', 'CONTRATOS.CONT_ID')
			->join('PERIODOSNOMINAS','PERIODOSNOMINAS.PENO_ID', '=', 'AUSENTISMOS.PENO_ID')
			->join('ENTIDADES','ENTIDADES.ENTI_ID', '=', 'AUSENTISMOS.ENTI_ID')
			->join('CONCEPTOAUSENCIAS','CONCEPTOAUSENCIAS.COAU_ID', '=', 'AUSENTISMOS.COAU_ID')
			->join('TIPOAUSENTISMOS','TIPOAUSENTISMOS.TIAU_ID', '=', 'CONCEPTOAUSENCIAS.TIAU_ID')
			->join('TIPOENTIDADES','TIPOENTIDADES.TIEN_ID', '=', 'CONCEPTOAUSENCIAS.TIEN_ID')
			->select([
				'AUSENTISMOS.AUSE_ID as CODIGO',
				'EMPLEADORES.EMPL_NOMBRECOMERCIAL as EMPRESA',
				'PROSPECTOS.PROS_CEDULA as CEDULA',
				expression_concat([
					'PROS_PRIMERAPELLIDO',
					'PROS_SEGUNDOAPELLIDO',
					'PROS_PRIMERNOMBRE',
					'PROS_SEGUNDONOMBRE'
				], 'NOMBRE_EMPLEADO', 'PROSPECTOS'),
				'AUSENTISMOS.AUSE_FECHAINICIO AS FECHA_INICIAL',
				'AUSENTISMOS.AUSE_DIAS AS NUM_DIAS',
				'AUSENTISMOS.AUSE_FECHAFINAL AS FECHA_FINAL',
				'TIPOAUSENTISMOS.TIAU_DESCRIPCION AS TIPO_AUSENTISMOS',
				'AUSENTISMOS.AUSE_FECHAACCIDENTE AS FECHA_ACCIDENTE',
				'PERIODOSNOMINAS.PENO_DESCRIPCION AS PERIODO',
				'CONCEPTOAUSENCIAS.COAU_DESCRIPCION AS CONCEPTO_AUSENCIA',
				'GERENCIAS.GERE_DESCRIPCION AS GERENCIA',
				'NEGOCIOS.NEGO_DESCRIPCION AS NEGOCIO',
				'TEMPORALES.TEMP_NOMBRECOMERCIAL as E.S.T',
				'CARGOS.CARG_DESCRIPCION AS CARGO',
				'TIPOAUSENTISMOS.TIAU_DESCRIPCION AS TIPO_AUSENTISMO',
				'TIPOENTIDADES.TIEN_DESCRIPCION AS TIPO_ENTIDAD',
				'ENTIDADES.ENTI_RAZONSOCIAL AS ENTIDAD_RESPONSABLE',
				expression_concat([
					'PROS_PRIMERAPELLIDO',
					'PROS_SEGUNDOAPELLIDO',
					'PROS_PRIMERNOMBRE',
					'PROS_SEGUNDONOMBRE'
				], 'JEFE_INMEDIATO', 'JEFES'),
				'GRUPOS.GRUP_DESCRIPCION AS GRUPO_EMPLEADO',
				'TURNOS.TURN_DESCRIPCION AS TURNO_EMPLEADO',
				expression_concat([
					'PROS_PRIMERAPELLIDO',
					'PROS_SEGUNDOAPELLIDO',
					'PROS_PRIMERNOMBRE',
					'PROS_SEGUNDONOMBRE'
				], 'GRUPO_RESPONSABLE', 'GRUPORESPONSABLE'),
			])
			->whereNull('AUSENTISMOS.AUSE_FECHAELIMINADO')
			->whereNull('CONTRATOS.CONT_FECHAELIMINADO');

			//hace la consulta con base en los permisos asignados
			$query = get_permisosgenerales(\Auth::user()->id, $query);

		return $query;
	}

	private function getQueryProrrogasOperaciones()
	{
		$query = Contrato::leftJoin('TEMPORALES', 'TEMPORALES.TEMP_ID', '=', 'CONTRATOS.TEMP_ID')
			->leftJoin('PROSPECTOS AS JEFES', 'JEFES.PROS_ID', '=', 'CONTRATOS.JEFE_ID')
			->join('PROSPECTOS', 'PROSPECTOS.PROS_ID', '=', 'CONTRATOS.PROS_ID')		
			->join('EMPLEADORES', 'EMPLEADORES.EMPL_ID', '=', 'CONTRATOS.EMPL_ID')
			->join('TIPOSCONTRATOS', 'TIPOSCONTRATOS.TICO_ID', '=', 'CONTRATOS.TICO_ID')
			->join('CARGOS', 'CARGOS.CARG_ID', '=', 'CONTRATOS.CARG_ID')
			->join('ESTADOSCONTRATOS', 'ESTADOSCONTRATOS.ESCO_ID', '=', 'CONTRATOS.ESCO_ID')
			->join('GERENCIAS', 'GERENCIAS.GERE_ID', '=', 'CONTRATOS.GERE_ID')
			->join('NEGOCIOS', 'NEGOCIOS.NEGO_ID', '=', 'CONTRATOS.NEGO_ID')
			->join('CENTROSCOSTOS', 'CENTROSCOSTOS.CECO_ID', '=', 'CONTRATOS.CECO_ID')
			->join('GRUPOS', 'GRUPOS.GRUP_ID', '=', 'CONTRATOS.GRUP_ID')
			->leftJoin('GRUPOS_RESPONSABLES', 'GRUPOS_RESPONSABLES.GRUP_ID', '=', 'GRUPOS.GRUP_ID')
			->leftJoin('PROSPECTOS AS GRUPORESPONSABLE', 'GRUPORESPONSABLE.PROS_ID', '=', 'GRUPOS_RESPONSABLES.PROS_ID')
			->join('TURNOS', 'TURNOS.TURN_ID', '=', 'CONTRATOS.TURN_ID')
			->join('AUSENTISMOS','AUSENTISMOS.CONT_ID', '=', 'CONTRATOS.CONT_ID')
			->join('PERIODOSNOMINAS','PERIODOSNOMINAS.PENO_ID', '=', 'AUSENTISMOS.PENO_ID')
			->join('ENTIDADES','ENTIDADES.ENTI_ID', '=', 'AUSENTISMOS.ENTI_ID')
			->join('CONCEPTOAUSENCIAS','CONCEPTOAUSENCIAS.COAU_ID', '=', 'AUSENTISMOS.COAU_ID')
			->join('TIPOAUSENTISMOS','TIPOAUSENTISMOS.TIAU_ID', '=', 'CONCEPTOAUSENCIAS.TIAU_ID')
			->join('TIPOENTIDADES','TIPOENTIDADES.TIEN_ID', '=', 'CONCEPTOAUSENCIAS.TIEN_ID')
			->join('PRORROGAAUSENTISMOS', 'PRORROGAAUSENTISMOS.AUSE_ID', '=', 'AUSENTISMOS.AUSE_ID')
			->select([
				'AUSENTISMOS.AUSE_ID as CODIGO_AUS_INICIAL',
				'EMPLEADORES.EMPL_NOMBRECOMERCIAL as EMPRESA',
				'PROSPECTOS.PROS_CEDULA as CEDULA',
				expression_concat([
					'PROS_PRIMERAPELLIDO',
					'PROS_SEGUNDOAPELLIDO',
					'PROS_PRIMERNOMBRE',
					'PROS_SEGUNDONOMBRE'
				], 'NOMBRE_EMPLEADO', 'PROSPECTOS'),
				'PRORROGAAUSENTISMOS.PROR_FECHAINICIO AS FECHA_INICIAL',
				'PRORROGAAUSENTISMOS.PROR_DIAS AS NUM_DIAS',
				'PRORROGAAUSENTISMOS.PROR_FECHAFINAL AS FECHA_FINAL',
				'TIPOAUSENTISMOS.TIAU_DESCRIPCION AS TIPO_AUSENTISMOS',
				'PERIODOSNOMINAS.PENO_DESCRIPCION AS PERIODO',
				'CONCEPTOAUSENCIAS.COAU_DESCRIPCION AS CONCEPTO_AUSENCIA',
				'GERENCIAS.GERE_DESCRIPCION AS GERENCIA',
				'NEGOCIOS.NEGO_DESCRIPCION AS NEGOCIO',
				'TEMPORALES.TEMP_NOMBRECOMERCIAL as E.S.T',
				'CARGOS.CARG_DESCRIPCION AS CARGO',
				'TIPOAUSENTISMOS.TIAU_DESCRIPCION AS TIPO_AUSENTISMO',
				'TIPOENTIDADES.TIEN_DESCRIPCION AS TIPO_ENTIDAD',
				'ENTIDADES.ENTI_RAZONSOCIAL AS ENTIDAD_RESPONSABLE',
				expression_concat([
					'PROS_PRIMERAPELLIDO',
					'PROS_SEGUNDOAPELLIDO',
					'PROS_PRIMERNOMBRE',
					'PROS_SEGUNDONOMBRE'
				], 'JEFE_INMEDIATO', 'JEFES'),
				'GRUPOS.GRUP_DESCRIPCION AS GRUPO_EMPLEADO',
				'TURNOS.TURN_DESCRIPCION AS TURNO_EMPLEADO',
				expression_concat([
					'PROS_PRIMERAPELLIDO',
					'PROS_SEGUNDOAPELLIDO',
					'PROS_PRIMERNOMBRE',
					'PROS_SEGUNDONOMBRE'
				], 'GRUPO_RESPONSABLE', 'GRUPORESPONSABLE'),
			])
			->whereNull('AUSENTISMOS.AUSE_FECHAELIMINADO')
			->whereNull('PRORROGAAUSENTISMOS.PROR_FECHAELIMINADO')
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
	public function listadoAusentismos()
	{
		$query = $this->getQuery();

		if(isset($this->data['fchaGrabacionDesde']))
			$query->whereDate('AUSENTISMOS.AUSE_FECHACREADO', '>=', Carbon::parse($this->data['fchaGrabacionDesde']));
		if(isset($this->data['fchaGrabacionHasta']))
			$query->whereDate('AUSENTISMOS.AUSE_FECHACREADO', '<=', Carbon::parse($this->data['fchaGrabacionHasta']));
		if(isset($this->data['empresa']))
			$query->where('CONTRATOS.EMPL_ID', '=', $this->data['empresa']);
		if(isset($this->data['gerencia']))
			$query->where('CONTRATOS.GERE_ID', '=', $this->data['gerencia']);
		if(isset($this->data['centrocosto']))
			$query->where('CONTRATOS.CECO_ID', '=', $this->data['centrocosto']);
		if(isset($this->data['estado']))
			$query->where('CONTRATOS.ESCO_ID', '=', $this->data['estado']);
		if(isset($this->data['temporal']))
			$query->where('CONTRATOS.TEMP_ID', '=', $this->data['temporal']);
		if(isset($this->data['cargo']))
			$query->where('CONTRATOS.CARG_ID', '=', $this->data['cargo']);
		if(isset($this->data['periodo']))
			$query->where('PERIODOSNOMINAS.PENO_ID', '=', $this->data['periodo']);
		if(isset($this->data['tipo']))
			$query->where('TIPOAUSENTISMOS.TIAU_ID', '=', $this->data['tipo']);
		if(isset($this->data['concepto']))
			$query->where('CONCEPTOAUSENCIAS.COAU_ID', '=', $this->data['concepto']);
		if(isset($this->data['periodo']))
			$query->where('AUSENTISMOS.PENO_ID', '=', $this->data['periodo']);
		if(isset($this->data['prospecto']))
			$query->where('PROSPECTOS.PROS_ID', '=', $this->data['prospecto']);

		return $this->buildJson($query);
	}

	/**
	 * 
	 *
	 * @return Json
	 */
	public function listadoAusentismosOperaciones()
	{
		$query = $this->getQueryOperaciones();

		if(isset($this->data['fchaGrabacionDesde']))
			$query->whereDate('AUSENTISMOS.AUSE_FECHACREADO', '>=', Carbon::parse($this->data['fchaGrabacionDesde']));
		if(isset($this->data['fchaGrabacionHasta']))
			$query->whereDate('AUSENTISMOS.AUSE_FECHACREADO', '<=', Carbon::parse($this->data['fchaGrabacionHasta']));
		if(isset($this->data['empresa']))
			$query->where('CONTRATOS.EMPL_ID', '=', $this->data['empresa']);
		if(isset($this->data['gerencia']))
			$query->where('CONTRATOS.GERE_ID', '=', $this->data['gerencia']);
		if(isset($this->data['centrocosto']))
			$query->where('CONTRATOS.CECO_ID', '=', $this->data['centrocosto']);
		if(isset($this->data['estado']))
			$query->where('CONTRATOS.ESCO_ID', '=', $this->data['estado']);
		if(isset($this->data['temporal']))
			$query->where('CONTRATOS.TEMP_ID', '=', $this->data['temporal']);
		if(isset($this->data['cargo']))
			$query->where('CONTRATOS.CARG_ID', '=', $this->data['cargo']);
		if(isset($this->data['periodo']))
			$query->where('PERIODOSNOMINAS.PENO_ID', '=', $this->data['periodo']);
		if(isset($this->data['tipo']))
			$query->where('TIPOAUSENTISMOS.TIAU_ID', '=', $this->data['tipo']);
		if(isset($this->data['concepto']))
			$query->where('CONCEPTOAUSENCIAS.COAU_ID', '=', $this->data['concepto']);
		if(isset($this->data['periodo']))
			$query->where('AUSENTISMOS.PENO_ID', '=', $this->data['periodo']);
		if(isset($this->data['prospecto']))
			$query->where('PROSPECTOS.PROS_ID', '=', $this->data['prospecto']);

		return $this->buildJson($query);
	}

	/**
	 * 
	 *
	 * @return Json
	 */
	public function listadoAusentismosProrrogasOperaciones()
	{
		$query = $this->getQueryProrrogasOperaciones();

		if(isset($this->data['fchaGrabacionDesde']))
			$query->whereDate('PRORROGAAUSENTISMOS.PROR_FECHACREADO', '>=', Carbon::parse($this->data['fchaGrabacionDesde']));
		if(isset($this->data['fchaGrabacionHasta']))
			$query->whereDate('PRORROGAAUSENTISMOS.PROR_FECHACREADO', '<=', Carbon::parse($this->data['fchaGrabacionHasta']));
		if(isset($this->data['empresa']))
			$query->where('CONTRATOS.EMPL_ID', '=', $this->data['empresa']);
		if(isset($this->data['gerencia']))
			$query->where('CONTRATOS.GERE_ID', '=', $this->data['gerencia']);
		if(isset($this->data['centrocosto']))
			$query->where('CONTRATOS.CECO_ID', '=', $this->data['centrocosto']);
		if(isset($this->data['estado']))
			$query->where('CONTRATOS.ESCO_ID', '=', $this->data['estado']);
		if(isset($this->data['temporal']))
			$query->where('CONTRATOS.TEMP_ID', '=', $this->data['temporal']);
		if(isset($this->data['cargo']))
			$query->where('CONTRATOS.CARG_ID', '=', $this->data['cargo']);
		if(isset($this->data['periodo']))
			$query->where('PERIODOSNOMINAS.PENO_ID', '=', $this->data['periodo']);
		if(isset($this->data['tipo']))
			$query->where('TIPOAUSENTISMOS.TIAU_ID', '=', $this->data['tipo']);
		if(isset($this->data['concepto']))
			$query->where('CONCEPTOAUSENCIAS.COAU_ID', '=', $this->data['concepto']);
		if(isset($this->data['periodo']))
			$query->where('PRORROGAAUSENTISMOS.PENO_ID', '=', $this->data['periodo']);
		if(isset($this->data['prospecto']))
			$query->where('PROSPECTOS.PROS_ID', '=', $this->data['prospecto']);

		return $this->buildJson($query);
	}

	/**
	 * 
	 *
	 * @return Json
	 */
	public function listadoAusentismosProrrogas()
	{
		$query = $this->getQueryProrrogas();

		if(isset($this->data['fchaGrabacionDesde']))
			$query->whereDate('PRORROGAAUSENTISMOS.PROR_FECHACREADO', '>=', Carbon::parse($this->data['fchaGrabacionDesde']));
		if(isset($this->data['fchaGrabacionHasta']))
			$query->whereDate('PRORROGAAUSENTISMOS.PROR_FECHACREADO', '<=', Carbon::parse($this->data['fchaGrabacionHasta']));
		if(isset($this->data['empresa']))
			$query->where('CONTRATOS.EMPL_ID', '=', $this->data['empresa']);
		if(isset($this->data['gerencia']))
			$query->where('CONTRATOS.GERE_ID', '=', $this->data['gerencia']);
		if(isset($this->data['centrocosto']))
			$query->where('CONTRATOS.CECO_ID', '=', $this->data['centrocosto']);
		if(isset($this->data['estado']))
			$query->where('CONTRATOS.ESCO_ID', '=', $this->data['estado']);
		if(isset($this->data['temporal']))
			$query->where('CONTRATOS.TEMP_ID', '=', $this->data['temporal']);
		if(isset($this->data['cargo']))
			$query->where('CONTRATOS.CARG_ID', '=', $this->data['cargo']);
		if(isset($this->data['periodo']))
			$query->where('PERIODOSNOMINAS.PENO_ID', '=', $this->data['periodo']);
		if(isset($this->data['tipo']))
			$query->where('TIPOAUSENTISMOS.TIAU_ID', '=', $this->data['tipo']);
		if(isset($this->data['concepto']))
			$query->where('CONCEPTOAUSENCIAS.COAU_ID', '=', $this->data['concepto']);
		if(isset($this->data['periodo']))
			$query->where('PRORROGAAUSENTISMOS.PENO_ID', '=', $this->data['periodo']);
		if(isset($this->data['prospecto']))
			$query->where('PROSPECTOS.PROS_ID', '=', $this->data['prospecto']);

		return $this->buildJson($query);
	}

}