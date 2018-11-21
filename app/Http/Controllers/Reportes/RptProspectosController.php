<?php
namespace App\Http\Controllers\Reportes;
use App\Http\Controllers\Controller;

use \Carbon\Carbon;

use App\Models\Prospecto;
use App\Models\EstadoContrato;

class RptProspectosController extends ReporteController
{

	public function __construct()
	{
		parent::__construct();
	}


	private function getQuery()
	{
		$query = Prospecto::leftJoin('BANCOS', 'BANCOS.BANC_ID', '=', 'PROSPECTOS.BANC_ID')	
				->join('TIPOSDOCUMENTOS', 'TIPOSDOCUMENTOS.TIDO_ID', '=', 'PROSPECTOS.TIDO_ID')	
				->select([
				'TIPOSDOCUMENTOS.TIDO_DESCRIPCION as TIPO_DOCUMENTO',
				'PROSPECTOS.PROS_CEDULA as CEDULA',
				expression_concat([
					'PROS_PRIMERAPELLIDO',
					'PROS_SEGUNDOAPELLIDO',
					'PROS_PRIMERNOMBRE',
					'PROS_SEGUNDONOMBRE'	
				], 'NOMBRE_EMPLEADO', 'PROSPECTOS'),
				'PROSPECTOS.PROS_FECHANACIMIENTO as FECHA_NACIMIENTO',
				'PROSPECTOS.PROS_FECHAEXPEDICION as FECHA_EXPEDICION',
				'PROSPECTOS.PROS_SEXO as SEXO',
				'PROSPECTOS.PROS_DIRECCION as DIRECCION',
				'PROSPECTOS.PROS_TELEFONO as TELEFONO',
				'PROSPECTOS.PROS_CELULAR as CELULAR',
				'PROSPECTOS.PROS_CORREO as EMAIL',
				'BANCOS.BANC_DESCRIPCION AS BANCO',
				'PROSPECTOS.PROS_TIPOCUENTA AS TIPO_CUENTA',
				'PROSPECTOS.PROS_CUENTA AS CUENTA',
			])
			->whereNull('PROSPECTOS.PROS_FECHAELIMINADO');
		return $query;
	}

	private function getQueryCumpleanios()
	{
		$query = Prospecto::join('CONTRATOS', 'CONTRATOS.PROS_ID', '=', 'PROSPECTOS.PROS_ID')
				->join('EMPLEADORES', 'EMPLEADORES.EMPL_ID', '=', 'CONTRATOS.EMPL_ID')
				->join('GERENCIAS', 'GERENCIAS.GERE_ID', '=', 'CONTRATOS.GERE_ID')
				->join('TIPOSCONTRATOS', 'TIPOSCONTRATOS.TICO_ID', '=', 'CONTRATOS.TICO_ID')
				->join('CLASESCONTRATOS', 'CLASESCONTRATOS.CLCO_ID', '=', 'CONTRATOS.CLCO_ID')
				->join('TIPOSDOCUMENTOS', 'TIPOSDOCUMENTOS.TIDO_ID', '=', 'PROSPECTOS.TIDO_ID')
				->join('ESTADOSCONTRATOS', 'ESTADOSCONTRATOS.ESCO_ID', '=', 'CONTRATOS.ESCO_ID')
				->join('CARGOS', 'CARGOS.CARG_ID', '=', 'CONTRATOS.CARG_ID')
				->leftJoin('TEMPORALES', 'TEMPORALES.TEMP_ID', '=', 'CONTRATOS.TEMP_ID')
				->select([
				'EMPLEADORES.EMPL_NOMBRECOMERCIAL AS EMPRESA',
				'TEMPORALES.TEMP_NOMBRECOMERCIAL as E.S.T',
				'GERENCIAS.GERE_DESCRIPCION AS GERENCIA',
				'ESTADOSCONTRATOS.ESCO_DESCRIPCION AS ESTADO',
				'TIPOSDOCUMENTOS.TIDO_DESCRIPCION AS TIPO_DOCUMENTO',
				'PROSPECTOS.PROS_CEDULA AS CEDULA',
				expression_concat([
					'PROS_PRIMERAPELLIDO',
					'PROS_SEGUNDOAPELLIDO',
					'PROS_PRIMERNOMBRE',
					'PROS_SEGUNDONOMBRE'	
				], 'NOMBRE_EMPLEADO', 'PROSPECTOS'),
				'PROSPECTOS.PROS_FECHANACIMIENTO AS FECHA_NACIMIENTO',
				'CARGOS.CARG_DESCRIPCION AS CARGO',
				'PROSPECTOS.PROS_SEXO AS SEXO',
				'PROSPECTOS.PROS_DIRECCION AS DIRECCION',
				'PROSPECTOS.PROS_TELEFONO AS TELEFONO',
				'PROSPECTOS.PROS_CELULAR AS CELULAR',
				'PROSPECTOS.PROS_CORREO AS EMAIL',
			])
			->whereNull('PROSPECTOS.PROS_FECHAELIMINADO');
		return $query;
	}


	/**
	 * 
	 *
	 * @return Json
	 */
	public function hojasDeVida()
	{
		$query = $this->getQuery();

		if(isset($this->data['prospecto']))
			$query->where('PROSPECTOS.PROS_ID', '=', $this->data['prospecto']);

		return $this->buildJson($query);
	}

	/**
	 * 
	 *
	 * @return Json
	 */
	public function hojasDeVidaDescartadas()
	{
		$query = $this->getQuery()
			->where('PROSPECTOS.PROS_MARCA', '=', 'SI')
			->addSelect([
				'PROSPECTOS.PROS_MARCA as ¿DESCARTADA?',
				'PROSPECTOS.PROS_MARCAOBSERVACIONES as OBSERVACIONES',
			]);

		if(isset($this->data['prospecto']))
			$query->where('PROSPECTOS.PROS_ID', '=', $this->data['prospecto']);

		return $this->buildJson($query);
	}

	/**
	 * 
	 *
	 * @return Json
	 */
	public function cumpleanios()
	{

		$db_start 	= Carbon::parse($this->data['fchaCumpleDesde']);
		$db_end		= Carbon::parse($this->data['fchaCumpleHasta']);

		$query = $this->getQueryCumpleanios()
			->whereIn('CONTRATOS.ESCO_ID', [EstadoContrato::ACTIVO, EstadoContrato::VACACIONES])
			->whereMonth('PROSPECTOS.PROS_FECHANACIMIENTO', '>=', $db_start->month)
			->whereDay('PROSPECTOS.PROS_FECHANACIMIENTO', '>=', $db_start->day)	
			->whereMonth('PROSPECTOS.PROS_FECHANACIMIENTO', '<=', $db_end->month)
			->whereDay('PROSPECTOS.PROS_FECHANACIMIENTO', '<=', $db_end->day);	

		if(isset($this->data['prospecto']))
			$query->where('PROSPECTOS.PROS_ID', '=', $this->data['prospecto']);

		return $this->buildJson($query);
	}



}