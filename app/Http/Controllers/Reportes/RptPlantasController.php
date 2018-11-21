<?php
namespace App\Http\Controllers\Reportes;
use App\Http\Controllers\Controller;

use App\Models\PlantaLaboral;
use App\Models\Contrato;
use App\Models\EstadoContrato;
use App\Models\TipoContrato;

class RptPlantasController extends ReporteController
{
	public function __construct()
	{
		parent::__construct();
	}


	private function getQuery()
	{

		//subquery para Postgrest ára obtener la variacion total de una planta laboral
		$sqlCantVarPlanta = 'COALESCE( (SELECT SUM("MOV"."MOPL_CANTIDAD") FROM "PLANTASLABORALES" AS "PLA"
			LEFT JOIN "MOVIMIENTOS_PLANTAS" AS "MOV"
				ON "PLA"."PALA_ID" = "MOV"."PALA_ID"
		    AND "PLA"."EMPL_ID" = "EMPLEADORES"."EMPL_ID"
		    AND "PLA"."GERE_ID" = "GERENCIAS"."GERE_ID"
		    AND "PLA"."CARG_ID" = "CARGOS"."CARG_ID"
		    AND "PLA"."GRUP_ID" = "GRUPOS"."GRUP_ID"
		    AND "PLA"."TURN_ID" = "TURNOS"."TURN_ID"
		    AND "PLA"."PALA_FECHAELIMINADO" IS NULL
		    AND "MOV"."MOPL_FECHAELIMINADO" IS NULL
		) , 0) AS "DIFERENCIA_AUTORIZADA"';
		//En Mysql, el query no debe tener comillas dobles.
        if(config('database.default') == 'mysql'){
    		$sqlCantVarPlanta = str_replace('"', '', $sqlCantVarPlanta);
        }

		$query = PlantaLaboral::join('EMPLEADORES', 'EMPLEADORES.EMPL_ID', '=', 'PLANTASLABORALES.EMPL_ID')
					->join('GERENCIAS', 'GERENCIAS.GERE_ID', '=', 'PLANTASLABORALES.GERE_ID')
					->join('GRUPOS', 'GRUPOS.GRUP_ID', '=', 'PLANTASLABORALES.GRUP_ID')
					->join('TURNOS', 'TURNOS.TURN_ID', '=', 'PLANTASLABORALES.TURN_ID')
					->join('CARGOS', 'CARGOS.CARG_ID', '=', 'PLANTASLABORALES.CARG_ID')
					->select([
						'EMPLEADORES.EMPL_NOMBRECOMERCIAL AS EMPRESA',
						'GERENCIAS.GERE_DESCRIPCION AS GERENCIA',
						'GRUPOS.GRUP_DESCRIPCION AS GRUPO',
						'TURNOS.TURN_DESCRIPCION AS TURNO',
						'CARGOS.CARG_DESCRIPCION AS CARGO',
						'PLANTASLABORALES.PALA_CANTIDAD AS PLANTA_AUTORIZADA',
						\DB::raw($sqlCantVarPlanta)
					])
					->whereNull('PLANTASLABORALES.PALA_FECHAELIMINADO')
					->orderBy('EMPRESA', 'asc')
					->orderBy('GERENCIA', 'asc')
					->orderBy('CARGO', 'asc')
					->orderBy('GRUPO', 'asc')
					->orderBy('TURNO', 'asc');

		//hace la consulta con base en los permisos asignados
		$query = get_permisosgenerales(\Auth::user()->id, $query);
		
		return $query;
	}

	private function getQueryIndicador()
	{

		//subquery para Postgrest ára obtener la variacion total de una planta laboral
		$sqlCantVarPlanta = 'COALESCE( (SELECT SUM("MOV"."MOPL_CANTIDAD") FROM "PLANTASLABORALES" AS "PLA"
			LEFT JOIN "MOVIMIENTOS_PLANTAS" AS "MOV"
				ON "PLA"."PALA_ID" = "MOV"."PALA_ID"
		    AND "PLA"."EMPL_ID" = "PLANTASLABORALES"."EMPL_ID"
		    AND "PLA"."GERE_ID" = "PLANTASLABORALES"."GERE_ID"
		    AND "PLA"."CARG_ID" = "PLANTASLABORALES"."CARG_ID"
		    AND "PLA"."PALA_FECHAELIMINADO" IS NULL
		    AND "MOV"."MOPL_FECHAELIMINADO" IS NULL
		) , 0) AS "DIFERENCIA_AUTORIZADA"';

		//subquery para Postgrest ára obtener la variacion total de una planta laboral
		$sqlSumPlanta = 'COALESCE( (SUM("PLANTASLABORALES"."PALA_CANTIDAD")
		) , 0) AS "PLANTA_AUTORIZADA"';
		//En Mysql, el query no debe tener comillas dobles.
        if(config('database.default') == 'mysql'){
    		$sqlCantVarPlanta = str_replace('"', '', $sqlCantVarPlanta);
        }

		$query = PlantaLaboral::join('EMPLEADORES', 'EMPLEADORES.EMPL_ID', '=', 'PLANTASLABORALES.EMPL_ID')
					->join('GERENCIAS', 'GERENCIAS.GERE_ID', '=', 'PLANTASLABORALES.GERE_ID')
					->join('CARGOS', 'CARGOS.CARG_ID', '=', 'PLANTASLABORALES.CARG_ID')
					->select([
						'EMPLEADORES.EMPL_NOMBRECOMERCIAL AS EMPRESA',
						'GERENCIAS.GERE_DESCRIPCION AS GERENCIA',
						'CARGOS.CARG_DESCRIPCION AS CARGO',
						//'PLANTASLABORALES.PALA_CANTIDAD AS PLANTA_AUTORIZADA',
						\DB::raw($sqlSumPlanta),
						\DB::raw($sqlCantVarPlanta)
					])
					->whereNull('PLANTASLABORALES.PALA_FECHAELIMINADO')
					->groupBy('EMPRESA','GERENCIA','CARGO','PLANTASLABORALES.EMPL_ID','PLANTASLABORALES.GERE_ID','PLANTASLABORALES.CARG_ID');

		//hace la consulta con base en los permisos asignados
		$query = get_permisosgenerales(\Auth::user()->id, $query);

		return $query;
	}

	private function getQueryVariaciones()
	{
		$query = PlantaLaboral::join('EMPLEADORES', 'EMPLEADORES.EMPL_ID', '=', 'PLANTASLABORALES.EMPL_ID')
					->join('GERENCIAS', 'GERENCIAS.GERE_ID', '=', 'PLANTASLABORALES.GERE_ID')
					->join('GRUPOS', 'GRUPOS.GRUP_ID', '=', 'PLANTASLABORALES.GRUP_ID')
					->join('TURNOS', 'TURNOS.TURN_ID', '=', 'PLANTASLABORALES.TURN_ID')
					->join('CARGOS', 'CARGOS.CARG_ID', '=', 'PLANTASLABORALES.CARG_ID')
					->select([
						'EMPLEADORES.EMPL_NOMBRECOMERCIAL AS EMPRESA',
						'GERENCIAS.GERE_DESCRIPCION AS GERENCIA',
						'GRUPOS.GRUP_DESCRIPCION AS GRUPO',
						'TURNOS.TURN_DESCRIPCION AS TURNO',
						'CARGOS.CARG_DESCRIPCION AS CARGO',
						'PLANTASLABORALES.PALA_CANTIDAD AS PLANTA_AUTORIZADA',
					])
					->whereNull('PLANTASLABORALES.PALA_FECHAELIMINADO');
		return $query;
	}


	/**
	 * 
	 *
	 * @return Json
	 */
	public function plantasAutorizadas()
	{
		$query = $this->getQuery();

		if(isset($this->data['empresa']))
			$query->where('EMPLEADORES.EMPL_ID', '=', $this->data['empresa']);
		if(isset($this->data['gerencia']))
			$query->where('GERENCIAS.GERE_ID', '=', $this->data['gerencia']);
		if(isset($this->data['grupo']))
			$query->where('GRUPOS.GRUP_ID', '=', $this->data['grupo']);
		if(isset($this->data['turno']))
			$query->where('TURNOS.TURN_ID', '=', $this->data['turno']);
		if(isset($this->data['cargo']))
			$query->where('CARGOS.CARG_ID', '=', $this->data['cargo']);

		return $this->buildJson($query);
	}

	/**
	 * 
	 *
	 * @return Json
	 */
	public function movimientosPlantas()
	{
		$query = $this->getQueryVariaciones()
			->join('MOVIMIENTOS_PLANTAS', 'MOVIMIENTOS_PLANTAS.PALA_ID', '=','PLANTASLABORALES.PALA_ID')
			->addSelect([
				'MOVIMIENTOS_PLANTAS.MOPL_CANTIDAD AS MOVIMIENTO',
				'MOVIMIENTOS_PLANTAS.MOPL_FECHAMOVIMIENTO AS FECHA_MOVIMIENTO',
				'MOVIMIENTOS_PLANTAS.MOPL_MOTIVO AS MOTIVO_MOVIMIENTO',
				'MOVIMIENTOS_PLANTAS.MOPL_OBSERVACIONES AS OBSERVACIONES',
			])
			->whereNull('MOVIMIENTOS_PLANTAS.MOPL_FECHAELIMINADO');

		if(isset($this->data['empresa']))
			$query->where('PLANTASLABORALES.EMPL_ID', '=', $this->data['empresa']);
		if(isset($this->data['gerencia']))
			$query->where('PLANTASLABORALES.GERE_ID', '=', $this->data['gerencia']);
		if(isset($this->data['grupo']))
			$query->where('PLANTASLABORALES.GRUP_ID', '=', $this->data['grupo']);
		if(isset($this->data['turno']))
			$query->where('PLANTASLABORALES.TURN_ID', '=', $this->data['turno']);
		if(isset($this->data['cargo']))
			$query->where('PLANTASLABORALES.CARG_ID', '=', $this->data['cargo']);

		return $this->buildJson($query);
	}


	/**
	 * 
	 *
	 * @return Json
	 */
	public function plantasVrsActivos()
	{
		//https://laracasts.com/discuss/channels/eloquent/add-a-left-join-in-laravel-querysubquery-builder
		/*$subQuery = \DB::table('CONTRATOS')
					->select(\DB::raw('COUNT(*)'))
					->join('EMPLEADORES', 'EMPLEADORES.EMPL_ID', '=', 'CONTRATOS.EMPL_ID')
					->join('GERENCIAS', 'GERENCIAS.GERE_ID', '=', 'CONTRATOS.GERE_ID')
					->join('CARGOS', 'CARGOS.CARG_ID', '=', 'CONTRATOS.CARG_ID')
					->whereIn('ESCO_ID', [EstadoContrato::ACTIVO,EstadoContrato::VACACIONES]);
		$subQuerySQL = $subQuery->toSql();

		$query = $this->getQuery()
			->addselect(\DB::raw("({$subQuerySQL}) as CANTIDAD_CONTRATOS"))
        	->mergeBindings($subQuery->getBindings());*/
        	

       	//Subquery para Postgres para cruzar contratos con Plantas
		$sqlCantContratosDirectos = '(SELECT COUNT(*) FROM "CONTRATOS"
			WHERE "CONTRATOS"."EMPL_ID" = "EMPLEADORES"."EMPL_ID"
			AND "CONTRATOS"."GERE_ID" = "GERENCIAS"."GERE_ID"
			AND "CONTRATOS"."GRUP_ID" = "GRUPOS"."GRUP_ID"
		    AND "CONTRATOS"."TURN_ID" = "TURNOS"."TURN_ID"
			AND "CONTRATOS"."CARG_ID" = "CARGOS"."CARG_ID"
			AND "CONTRATOS"."CONT_FECHAELIMINADO" IS NULL
			AND "CONTRATOS"."ESCO_ID" IN ('.EstadoContrato::ACTIVO.','.EstadoContrato::VACACIONES.'.)
			AND "CONTRATOS"."TICO_ID" = '.TipoContrato::DIRECTO.'.
		) AS "PERSONAL_DIRECTO"';

		//Subquery para Postgres para cruzar contratos con Plantas
		$sqlCantContratosTemporales = '(SELECT COUNT(*) FROM "CONTRATOS"
			WHERE "CONTRATOS"."EMPL_ID" = "EMPLEADORES"."EMPL_ID"
			AND "CONTRATOS"."GERE_ID" = "GERENCIAS"."GERE_ID"
			AND "CONTRATOS"."GRUP_ID" = "GRUPOS"."GRUP_ID"
		    AND "CONTRATOS"."TURN_ID" = "TURNOS"."TURN_ID"
			AND "CONTRATOS"."CARG_ID" = "CARGOS"."CARG_ID"
			AND "CONTRATOS"."CONT_FECHAELIMINADO" IS NULL
			AND "CONTRATOS"."ESCO_ID" IN ('.EstadoContrato::ACTIVO.','.EstadoContrato::VACACIONES.'.)
			AND "CONTRATOS"."TICO_ID" = '.TipoContrato::INDIRECTO.'.
		) AS "PERSONAL_TEMPORAL"';

		//Subquery para calcular la diferencia entre la planta total autorizada vs los activos total 

		$sqlDiferencia = '
		(SELECT COUNT(*) FROM "CONTRATOS"
			WHERE "CONTRATOS"."EMPL_ID" = "EMPLEADORES"."EMPL_ID"
			AND "CONTRATOS"."GERE_ID" = "GERENCIAS"."GERE_ID"
			AND "CONTRATOS"."GRUP_ID" = "GRUPOS"."GRUP_ID"
		    AND "CONTRATOS"."TURN_ID" = "TURNOS"."TURN_ID"
			AND "CONTRATOS"."CARG_ID" = "CARGOS"."CARG_ID"
			AND "CONTRATOS"."CONT_FECHAELIMINADO" IS NULL
			AND "CONTRATOS"."ESCO_ID" IN ('.EstadoContrato::ACTIVO.','.EstadoContrato::VACACIONES.'.)
			AND "CONTRATOS"."TICO_ID" = '.TipoContrato::DIRECTO.'.
		) +
		(SELECT COUNT(*) FROM "CONTRATOS"
			WHERE "CONTRATOS"."EMPL_ID" = "EMPLEADORES"."EMPL_ID"
			AND "CONTRATOS"."GERE_ID" = "GERENCIAS"."GERE_ID"
			AND "CONTRATOS"."GRUP_ID" = "GRUPOS"."GRUP_ID"
		    AND "CONTRATOS"."TURN_ID" = "TURNOS"."TURN_ID"
			AND "CONTRATOS"."CARG_ID" = "CARGOS"."CARG_ID"
			AND "CONTRATOS"."CONT_FECHAELIMINADO" IS NULL
			AND "CONTRATOS"."ESCO_ID" IN ('.EstadoContrato::ACTIVO.','.EstadoContrato::VACACIONES.'.)
			AND "CONTRATOS"."TICO_ID" = '.TipoContrato::INDIRECTO.'.
		) -
		COALESCE( (SELECT SUM("MOV"."MOPL_CANTIDAD") FROM "PLANTASLABORALES" AS "PLA"
			LEFT JOIN "MOVIMIENTOS_PLANTAS" AS "MOV"
				ON "PLA"."PALA_ID" = "MOV"."PALA_ID"
		    AND "PLA"."EMPL_ID" = "EMPLEADORES"."EMPL_ID"
		    AND "PLA"."GERE_ID" = "GERENCIAS"."GERE_ID"
		    AND "PLA"."CARG_ID" = "CARGOS"."CARG_ID"
		    AND "PLA"."GRUP_ID" = "GRUPOS"."GRUP_ID"
		    AND "PLA"."TURN_ID" = "TURNOS"."TURN_ID"
		    AND "PLA"."PALA_FECHAELIMINADO" IS NULL
		    AND "MOV"."MOPL_FECHAELIMINADO" IS NULL
		) , 0) - "PLANTASLABORALES"."PALA_CANTIDAD"
		
		AS "DIFERENCIA"';

		//En Mysql, el query no debe tener comillas dobles.
        if(config('database.default') == 'mysql'){
    		$sqlCantContratosDirectos = str_replace('"', '', $sqlCantContratosDirectos);
    		$sqlCantContratosTemporales = str_replace('"', '', $sqlCantContratosTemporales);
        }

		$query = $this->getQuery()
		->addSelect([
					\DB::raw($sqlCantContratosDirectos),
					\DB::raw($sqlCantContratosTemporales),
					\DB::raw($sqlDiferencia)
				   ])
				   ->orderBy('EMPRESA', 'asc')
				   ->orderBy('GERENCIA', 'asc')
				   ->orderBy('CARGO', 'asc')
				   ->orderBy('GRUPO', 'asc')
				   ->orderBy('TURNO', 'asc');

		if(isset($this->data['empresa']))
			$query->where('PLANTASLABORALES.EMPL_ID', '=', $this->data['empresa']);
		if(isset($this->data['gerencia']))
			$query->where('PLANTASLABORALES.GERE_ID', '=', $this->data['gerencia']);
		if(isset($this->data['grupo']))
			$query->where('PLANTASLABORALES.GRUP_ID', '=', $this->data['grupo']);
		if(isset($this->data['turno']))
			$query->where('PLANTASLABORALES.TURN_ID', '=', $this->data['turno']);
		if(isset($this->data['cargo']))
			$query->where('PLANTASLABORALES.CARG_ID', '=', $this->data['cargo']);
		//dd($query->toSql());
		return $this->buildJson($query);
	}


	/**
	 * 
	 *
	 * @return Json
	 */
	public function plantasVrsActivosIndicador()
	{
       	//Subquery para Postgres para cruzar contratos con Plantas
		$sqlActivos = '(SELECT COUNT(*) FROM "CONTRATOS"
			WHERE "CONTRATOS"."EMPL_ID" = "PLANTASLABORALES"."EMPL_ID"
			AND "CONTRATOS"."GERE_ID" = "PLANTASLABORALES"."GERE_ID"
			AND "CONTRATOS"."CARG_ID" = "PLANTASLABORALES"."CARG_ID"
			AND "CONTRATOS"."CONT_FECHAELIMINADO" IS NULL
			AND "CONTRATOS"."ESCO_ID" IN ('.EstadoContrato::ACTIVO.','.EstadoContrato::VACACIONES.'.)
			AND "CONTRATOS"."TICO_ID" = '.TipoContrato::DIRECTO.'.
		) +
		(SELECT COUNT(*) FROM "CONTRATOS"
			WHERE "CONTRATOS"."EMPL_ID" = "PLANTASLABORALES"."EMPL_ID"
			AND "CONTRATOS"."GERE_ID" = "PLANTASLABORALES"."GERE_ID"
			AND "CONTRATOS"."CARG_ID" = "PLANTASLABORALES"."CARG_ID"
			AND "CONTRATOS"."CONT_FECHAELIMINADO" IS NULL
			AND "CONTRATOS"."ESCO_ID" IN ('.EstadoContrato::ACTIVO.','.EstadoContrato::VACACIONES.'.)
			AND "CONTRATOS"."TICO_ID" = '.TipoContrato::INDIRECTO.'.
		)
		AS "ACTIVOS"';

		//Subquery para calcular la diferencia entre la planta total autorizada vs los activos total 
		$sqlDiferencia = '
		(SELECT COUNT(*) FROM "CONTRATOS"
			WHERE "CONTRATOS"."EMPL_ID" = "PLANTASLABORALES"."EMPL_ID"
			AND "CONTRATOS"."GERE_ID" = "PLANTASLABORALES"."GERE_ID"
			AND "CONTRATOS"."CARG_ID" = "PLANTASLABORALES"."CARG_ID"
			AND "CONTRATOS"."CONT_FECHAELIMINADO" IS NULL
			AND "CONTRATOS"."ESCO_ID" IN ('.EstadoContrato::ACTIVO.','.EstadoContrato::VACACIONES.'.)
			AND "CONTRATOS"."TICO_ID" = '.TipoContrato::DIRECTO.'.
		) +
		(SELECT COUNT(*) FROM "CONTRATOS"
			WHERE "CONTRATOS"."EMPL_ID" = "PLANTASLABORALES"."EMPL_ID"
			AND "CONTRATOS"."GERE_ID" = "PLANTASLABORALES"."GERE_ID"
			AND "CONTRATOS"."CARG_ID" = "PLANTASLABORALES"."CARG_ID"
			AND "CONTRATOS"."CONT_FECHAELIMINADO" IS NULL
			AND "CONTRATOS"."ESCO_ID" IN ('.EstadoContrato::ACTIVO.','.EstadoContrato::VACACIONES.'.)
			AND "CONTRATOS"."TICO_ID" = '.TipoContrato::INDIRECTO.'.
		)
		-
		COALESCE( (SELECT SUM("MOV"."MOPL_CANTIDAD") FROM "PLANTASLABORALES" AS "PLA"
			LEFT JOIN "MOVIMIENTOS_PLANTAS" AS "MOV"
				ON "PLA"."PALA_ID" = "MOV"."PALA_ID"
		    AND "PLA"."EMPL_ID" = "PLANTASLABORALES"."EMPL_ID"
		    AND "PLA"."GERE_ID" = "PLANTASLABORALES"."GERE_ID"
		    AND "PLA"."CARG_ID" = "PLANTASLABORALES"."CARG_ID"
		    AND "PLA"."PALA_FECHAELIMINADO" IS NULL
		    AND "MOV"."MOPL_FECHAELIMINADO" IS NULL
		) , 0) -
		COALESCE( (SUM("PLANTASLABORALES"."PALA_CANTIDAD")) , 0)
		AS "DIFERENCIA"';

		//En Mysql, el query no debe tener comillas dobles.
        if(config('database.default') == 'mysql'){
    		$sqlActivos = str_replace('"', '', $sqlActivos);
    		$sqlCantContratosTemporales = str_replace('"', '', $sqlCantContratosTemporales);
        }

		$query = $this->getQueryIndicador()
		->addSelect([
					\DB::raw($sqlActivos),
					//\DB::raw($sqlCantContratosTemporales),
					\DB::raw($sqlDiferencia)
				   ])
				   ->orderBy('EMPRESA', 'asc')
				   ->orderBy('GERENCIA', 'asc')
				   ->orderBy('CARGO', 'asc');

		if(isset($this->data['empresa']))
			$query->where('PLANTASLABORALES.EMPL_ID', '=', $this->data['empresa']);
		if(isset($this->data['gerencia']))
			$query->where('PLANTASLABORALES.GERE_ID', '=', $this->data['gerencia']);
		if(isset($this->data['grupo']))
			$query->where('PLANTASLABORALES.GRUP_ID', '=', $this->data['grupo']);
		if(isset($this->data['turno']))
			$query->where('PLANTASLABORALES.TURN_ID', '=', $this->data['turno']);
		if(isset($this->data['cargo']))
			$query->where('PLANTASLABORALES.CARG_ID', '=', $this->data['cargo']);


		//dd($query->toSql());
		return $this->buildJson($query);
	}

}