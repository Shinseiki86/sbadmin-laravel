<?php
namespace App\Http\Controllers\Reportes;
use App\Http\Controllers\Controller;

use \Carbon\Carbon;

use App\Models\Contrato;
use App\Models\EstadoContrato;
use App\Models\TipoContrato;
use App\Models\ClaseContrato;
use App\Models\ParametroGeneral;
use App\Models\TipoEntidad;
use App\Models\Grupo;
use App\Models\Turno;
use App\Models\MotivoRetiro;

class RptContratosController extends ReporteController
{

	public function __construct()
	{
		parent::__construct();
	}


	private function getQuery()
	{

		//Subquery para Postgres para ARL
		$sqlArl = '(SELECT "ENTIDADES"."ENTI_RAZONSOCIAL" || '. "'"." ["."'" .   '|| "ENTIDADES"."ENTI_CODIGO"' 
			. "|| '"."]"."'" . 
			'FROM "ENTIDADES"
			JOIN "CONTRATO_ENTIDAD"
				ON "CONTRATO_ENTIDAD"."ENTI_ID" = "ENTIDADES"."ENTI_ID"
			JOIN "CONTRATOS" AS "CON"
				ON "CON"."CONT_ID" = "CONTRATO_ENTIDAD"."CONT_ID"
			WHERE "ENTIDADES"."TIEN_ID" =' . TipoEntidad::ARL .
			' AND "CON"."CONT_ID" = "CONTRATOS"."CONT_ID"' .
			') AS "ARL"';

		if(config('database.default') == 'mysql'){
    		$sqlArl = str_replace('"', '', $sqlArl);
        }

        //Subquery para Postgres para AFP
		$sqlAfp = '(SELECT "ENTIDADES"."ENTI_RAZONSOCIAL" || '. "'"." ["."'" .   '|| "ENTIDADES"."ENTI_CODIGO"' 
			. "|| '"."]"."'" . 
			'FROM "ENTIDADES"
			JOIN "CONTRATO_ENTIDAD"
				ON "CONTRATO_ENTIDAD"."ENTI_ID" = "ENTIDADES"."ENTI_ID"
			JOIN "CONTRATOS" AS "CON"
				ON "CON"."CONT_ID" = "CONTRATO_ENTIDAD"."CONT_ID"
			WHERE "ENTIDADES"."TIEN_ID" =' . TipoEntidad::AFP .
			' AND "CON"."CONT_ID" = "CONTRATOS"."CONT_ID"' .
			') AS "FONDO_PENSIONES"';

		if(config('database.default') == 'mysql'){
    		$sqlAfp = str_replace('"', '', $sqlAfp);
        }

        //Subquery para Postgres para AFC
		$sqlAfc= '(SELECT "ENTIDADES"."ENTI_RAZONSOCIAL" || '. "'"." ["."'" .   '|| "ENTIDADES"."ENTI_CODIGO"' 
			. "|| '"."]"."'" . 
			'FROM "ENTIDADES"
			JOIN "CONTRATO_ENTIDAD"
				ON "CONTRATO_ENTIDAD"."ENTI_ID" = "ENTIDADES"."ENTI_ID"
			JOIN "CONTRATOS" AS "CON"
				ON "CON"."CONT_ID" = "CONTRATO_ENTIDAD"."CONT_ID"
			WHERE "ENTIDADES"."TIEN_ID" =' . TipoEntidad::AFC .
			' AND "CON"."CONT_ID" = "CONTRATOS"."CONT_ID"' .
			') AS "FONDO_CESANTIAS"';

		if(config('database.default') == 'mysql'){
    		$sqlAfc = str_replace('"', '', $sqlAfc);
        }

        //Subquery para Postgres para EPS
		$sqlEps= '(SELECT "ENTIDADES"."ENTI_RAZONSOCIAL" || '. "'"." ["."'" .   '|| "ENTIDADES"."ENTI_CODIGO"' 
			. "|| '"."]"."'" . 
			'FROM "ENTIDADES"
			JOIN "CONTRATO_ENTIDAD"
				ON "CONTRATO_ENTIDAD"."ENTI_ID" = "ENTIDADES"."ENTI_ID"
			JOIN "CONTRATOS" AS "CON"
				ON "CON"."CONT_ID" = "CONTRATO_ENTIDAD"."CONT_ID"
			WHERE "ENTIDADES"."TIEN_ID" =' . TipoEntidad::EPS .
			' AND "CON"."CONT_ID" = "CONTRATOS"."CONT_ID"' .
			') AS "EPS"';

		if(config('database.default') == 'mysql'){
    		$sqlEps = str_replace('"', '', $sqlEps);
        }

        //Subquery para Postgres para CCF
		$sqlCcf= '(SELECT "ENTIDADES"."ENTI_RAZONSOCIAL" || '. "'"." ["."'" .   '|| "ENTIDADES"."ENTI_CODIGO"' 
			. "|| '"."]"."'" . 
			'FROM "ENTIDADES"
			JOIN "CONTRATO_ENTIDAD"
				ON "CONTRATO_ENTIDAD"."ENTI_ID" = "ENTIDADES"."ENTI_ID"
			JOIN "CONTRATOS" AS "CON"
				ON "CON"."CONT_ID" = "CONTRATO_ENTIDAD"."CONT_ID"
			WHERE "ENTIDADES"."TIEN_ID" =' . TipoEntidad::CCF .
			' AND "CON"."CONT_ID" = "CONTRATOS"."CONT_ID"' .
			') AS "CAJA_COMPENSACION"';

		if(config('database.default') == 'mysql'){
    		$sqlCcf = str_replace('"', '', $sqlCcf);
        }

        //Subquery para Postgres para mostrar el atributo de pago exitoso de liquidación
		$sqlLps= '(SELECT "ATRIBUTOS"."ATRI_DESCRIPCION" 
					FROM "ATRIBUTOS"
					INNER JOIN "EMPLEADOATRIBUTO"
						ON "EMPLEADOATRIBUTO"."ATRI_ID" = "ATRIBUTOS"."ATRI_ID"
					INNER JOIN "CONTRATOS" AS "CON"
						ON "EMPLEADOATRIBUTO"."CONT_ID" = "CON"."CONT_ID"
					WHERE "EMPLEADOATRIBUTO"."ATRI_ID" = 2
					AND "CON"."CONT_ID" = "CONTRATOS"."CONT_ID"' .
			') AS "LIQUIDACION_ESTADO"';

		if(config('database.default') == 'mysql'){
    		$sqlLps = str_replace('"', '', $sqlLps);
        }

		$query = Contrato::leftJoin('TEMPORALES', 'TEMPORALES.TEMP_ID', '=', 'CONTRATOS.TEMP_ID')
			->leftJoin('MOTIVOSRETIROS', 'MOTIVOSRETIROS.MORE_ID', '=', 'CONTRATOS.MORE_ID')
			->leftJoin('PROSPECTOS AS JEFES', 'JEFES.PROS_ID', '=', 'CONTRATOS.JEFE_ID')
			->leftJoin('PROSPECTOS AS REMPLAZOS', 'REMPLAZOS.PROS_ID', '=', 'CONTRATOS.REMP_ID')
			->join('PROSPECTOS', 'PROSPECTOS.PROS_ID', '=', 'CONTRATOS.PROS_ID')
			->join('TIPOSDOCUMENTOS', 'TIPOSDOCUMENTOS.TIDO_ID', '=', 'PROSPECTOS.TIDO_ID')
			->leftJoin('BANCOS', 'BANCOS.BANC_ID', '=', 'PROSPECTOS.BANC_ID')	
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
			->join('GRUPOS', 'GRUPOS.GRUP_ID', '=', 'CONTRATOS.GRUP_ID')
			->leftJoin('GRUPOS_RESPONSABLES', 'GRUPOS_RESPONSABLES.GRUP_ID', '=', 'GRUPOS.GRUP_ID')
			->leftJoin('PROSPECTOS AS GRUPORESPONSABLE', 'GRUPORESPONSABLE.PROS_ID', '=', 'GRUPOS_RESPONSABLES.PROS_ID')
			->join('TURNOS', 'TURNOS.TURN_ID', '=', 'CONTRATOS.TURN_ID')
			->join('CIUDADES AS CIUDADES_CONTRATA', 'CIUDADES_CONTRATA.CIUD_ID', '=', 'CONTRATOS.CIUD_CONTRATA')
			->join('CIUDADES AS CIUDADES_SERVICIO', 'CIUDADES_SERVICIO.CIUD_ID', '=', 'CONTRATOS.CIUD_SERVICIO')
			->select([
				'EMPLEADORES.EMPL_NOMBRECOMERCIAL as EMPRESA',
				'GERENCIAS.GERE_DESCRIPCION AS GERENCIA',
				'CENTROSCOSTOS.CECO_CODIGO AS CCOSTO',
				'CENTROSCOSTOS.CECO_DESCRIPCION AS CENTRO_COSTO',
				'TEMPORALES.TEMP_NOMBRECOMERCIAL as E.S.T',
				'TIPOSCONTRATOS.TICO_DESCRIPCION as TIPO_CONTRATO',
				'CLASESCONTRATOS.CLCO_DESCRIPCION as CLASE_CONTRATO',
				'TIPOSDOCUMENTOS.TIDO_DESCRIPCION as TIPO_DOCUMENTO',
				'PROSPECTOS.PROS_CEDULA as CEDULA',
				expression_concat([
					'PROS_PRIMERAPELLIDO',
					'PROS_SEGUNDOAPELLIDO',
					'PROS_PRIMERNOMBRE',
					'PROS_SEGUNDONOMBRE'
				], 'NOMBRE_EMPLEADO', 'PROSPECTOS'),
				'CONTRATOS.CONT_SALARIO AS SALARIO',
				'CARGOS.CARG_DESCRIPCION AS CARGO',
				'ESTADOSCONTRATOS.ESCO_DESCRIPCION AS ESTADO',
				'CONTRATOS.CONT_FECHAINGRESO AS FECHA_INGRESO',
				'CONTRATOS.CONT_FECHATERMINACION AS FECHA_FIN_CONTRATO',
				'CONTRATOS.CONT_FECHARETIRO AS FECHA_RETIRO',
				'CONTRATOS.CONT_FECHAGRABARETIRO AS FECHA_GRABA_RETIRO',
				'MOTIVOSRETIROS.MORE_DESCRIPCION AS MOTIVO_RETIRO',
				'CONTRATOS.CONT_VARIABLE AS VARIABLE',
				'CONTRATOS.CONT_RODAJE AS RODAJE',
				'TIPOSEMPLEADORES.TIEM_DESCRIPCION AS TIPO_EMPLEADOR',
				'RIESGOS.RIES_DESCRIPCION AS RIESGO',
				'NEGOCIOS.NEGO_DESCRIPCION AS NEGOCIO',
				'GRUPOS.GRUP_DESCRIPCION AS GRUPO_EMPLEADO',
				'TURNOS.TURN_DESCRIPCION AS TURNO_EMPLEADO',
				expression_concat([
					'PROS_PRIMERAPELLIDO',
					'PROS_SEGUNDOAPELLIDO',
					'PROS_PRIMERNOMBRE',
					'PROS_SEGUNDONOMBRE'
				], 'GRUPO_RESPONSABLE', 'GRUPORESPONSABLE'),
				'PROSPECTOS.PROS_FECHANACIMIENTO as FECHA_NACIMIENTO',
				'PROSPECTOS.PROS_SEXO AS SEXO',
				'BANCOS.BANC_DESCRIPCION AS BANCO',
				'PROSPECTOS.PROS_TIPOCUENTA AS TIPO_CUENTA',
				'PROSPECTOS.PROS_CUENTA AS CUENTA',
				'CONTRATOS.CONT_CASOMEDICO AS CASO_MEDICO',
				expression_concat([
					'PROS_PRIMERAPELLIDO',
					'PROS_SEGUNDOAPELLIDO',
					'PROS_PRIMERNOMBRE',
					'PROS_SEGUNDONOMBRE'
				], 'JEFE_INMEDIATO', 'JEFES'),
				expression_concat([
					'PROS_PRIMERAPELLIDO',
					'PROS_SEGUNDOAPELLIDO',
					'PROS_PRIMERNOMBRE',
					'PROS_SEGUNDONOMBRE'
				], 'REMPLAZA_A', 'REMPLAZOS'),
				'CIUDADES_CONTRATA.CIUD_NOMBRE AS CIUDAD_CONTRATO',
				'CIUDADES_SERVICIO.CIUD_NOMBRE AS CIUDAD_SERVICIO',
				\DB::raw($sqlAfp),
				\DB::raw($sqlAfc),
				\DB::raw($sqlEps),
				\DB::raw($sqlCcf),
				\DB::raw($sqlArl),
				'CONTRATOS.CONT_OBSERVACIONES AS OBSERVACIONES',
				'CONTRATOS.CONT_MOREOBSERVACIONES AS OBSERVACIONES_RETIRO',
				\DB::raw($sqlLps),
				'CONT_CREADOPOR AS CREADO_POR',
				'CONT_FECHACREADO AS FECHA_CREADO'
			])
			->whereNull('CONTRATOS.CONT_FECHAELIMINADO')
			->orderBy('EMPRESA', 'asc')
			->orderBy('GERENCIA', 'asc')
			->orderBy('CENTRO_COSTO', 'asc')
			->orderBy('CARGO', 'asc');

		//hace la consulta con base en los permisos asignados
		$query = get_permisosgenerales(\Auth::user()->id, $query);

		return $query;
	}

	private function getQueryAtributos()
	{
		$query = Contrato::leftJoin('TEMPORALES', 'TEMPORALES.TEMP_ID', '=', 'CONTRATOS.TEMP_ID')
			->leftJoin('MOTIVOSRETIROS', 'MOTIVOSRETIROS.MORE_ID', '=', 'CONTRATOS.MORE_ID')
			->leftJoin('PROSPECTOS AS JEFES', 'JEFES.PROS_ID', '=', 'CONTRATOS.JEFE_ID')
			->leftJoin('PROSPECTOS AS REMPLAZOS', 'REMPLAZOS.PROS_ID', '=', 'CONTRATOS.REMP_ID')
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
			->join('GRUPOS', 'GRUPOS.GRUP_ID', '=', 'CONTRATOS.GRUP_ID')
			->leftJoin('GRUPOS_RESPONSABLES', 'GRUPOS_RESPONSABLES.GRUP_ID', '=', 'GRUPOS.GRUP_ID')
			->leftJoin('PROSPECTOS AS GRUPORESPONSABLE', 'GRUPORESPONSABLE.PROS_ID', '=', 'GRUPOS_RESPONSABLES.PROS_ID')
			->join('TURNOS', 'TURNOS.TURN_ID', '=', 'CONTRATOS.TURN_ID')
			->join('CIUDADES AS CIUDADES_CONTRATA', 'CIUDADES_CONTRATA.CIUD_ID', '=', 'CONTRATOS.CIUD_CONTRATA')
			->join('CIUDADES AS CIUDADES_SERVICIO', 'CIUDADES_SERVICIO.CIUD_ID', '=', 'CONTRATOS.CIUD_SERVICIO')
			->join('EMPLEADOATRIBUTO', 'EMPLEADOATRIBUTO.CONT_ID', '=', 'CONTRATOS.CONT_ID')
			->join('ATRIBUTOS', 'ATRIBUTOS.ATRI_ID', '=', 'EMPLEADOATRIBUTO.ATRI_ID')
			->select([
				'EMPLEADORES.EMPL_NOMBRECOMERCIAL as EMPRESA',
				'GERENCIAS.GERE_DESCRIPCION AS GERENCIA',
				'CENTROSCOSTOS.CECO_CODIGO AS CCOSTO',
				'CENTROSCOSTOS.CECO_DESCRIPCION AS CENTRO_COSTO',
				'TEMPORALES.TEMP_NOMBRECOMERCIAL as E.S.T',
				'TIPOSCONTRATOS.TICO_DESCRIPCION as TIPO_CONTRATO',
				'CLASESCONTRATOS.CLCO_DESCRIPCION as CLASE_CONTRATO',
				'PROSPECTOS.PROS_CEDULA as CEDULA',
				expression_concat([
					'PROS_PRIMERAPELLIDO',
					'PROS_SEGUNDOAPELLIDO',
					'PROS_PRIMERNOMBRE',
					'PROS_SEGUNDONOMBRE'
				], 'NOMBRE_EMPLEADO', 'PROSPECTOS'),
				'CARGOS.CARG_DESCRIPCION AS CARGO',
				'ESTADOSCONTRATOS.ESCO_DESCRIPCION AS ESTADO',
				'CONT_FECHAINGRESO AS FECHA_INGRESO',
				'CONT_FECHARETIRO AS FECHA_RETIRO',
				'MORE_DESCRIPCION AS MOTIVO_RETIRO',
				'TIPOSEMPLEADORES.TIEM_DESCRIPCION AS TIPO_EMPLEADOR',
				'ATRIBUTOS.ATRI_DESCRIPCION AS ATRIBUTO',
				'EMPLEADOATRIBUTO.EMAT_FECHA AS FECHA_ATRIBUTO',
				'EMPLEADOATRIBUTO.EMAT_VALOR AS VALOR_ATRIBUTO',
				'GRUPOS.GRUP_DESCRIPCION AS GRUPO_EMPLEADO',
				'TURNOS.TURN_DESCRIPCION AS TURNO_EMPLEADO',
				expression_concat([
					'PROS_PRIMERAPELLIDO',
					'PROS_SEGUNDOAPELLIDO',
					'PROS_PRIMERNOMBRE',
					'PROS_SEGUNDONOMBRE'
				], 'GRUPO_RESPONSABLE', 'GRUPORESPONSABLE'),
				'EMPLEADOATRIBUTO.EMAT_OBSERVACIONES AS OBSERVACIONES_ATRIBUTO',
			])
			->whereNull('CONTRATOS.CONT_FECHAELIMINADO')
			->whereNull('EMPLEADOATRIBUTO.EMAT_FECHAELIMINADO')
			->orderBy('EMPRESA', 'asc')
			->orderBy('GERENCIA', 'asc')
			->orderBy('CENTRO_COSTO', 'asc')
			->orderBy('CARGO', 'asc');

		//hace la consulta con base en los permisos asignados
		$query = get_permisosgenerales(\Auth::user()->id, $query);

		return $query;
	}

	private function getQueryRm()
	{
		//Subquery para Postgres para cruzar contratos con Plantas
		$sqlCantContratos = '(SELECT COUNT(*) FROM "CONTRATOS"
			WHERE "CONTRATOS"."PROS_ID" = "PROSPECTOS"."PROS_ID"
		) AS "CANTIDAD_CONTRATOS"';
		//En Mysql, el query no debe tener comillas dobles.
        if(config('database.default') == 'mysql'){
    		$sqlCantContratos = str_replace('"', '', $sqlCantContratos);
        }


		$query = Contrato::leftJoin('TEMPORALES', 'TEMPORALES.TEMP_ID', '=', 'CONTRATOS.TEMP_ID')
			->leftJoin('MOTIVOSRETIROS', 'MOTIVOSRETIROS.MORE_ID', '=', 'CONTRATOS.MORE_ID')
			->leftJoin('PROSPECTOS AS JEFES', 'JEFES.PROS_ID', '=', 'CONTRATOS.JEFE_ID')
			->leftJoin('PROSPECTOS AS REMPLAZOS', 'REMPLAZOS.PROS_ID', '=', 'CONTRATOS.REMP_ID')
			->join('PROSPECTOS', 'PROSPECTOS.PROS_ID', '=', 'CONTRATOS.PROS_ID')
			->join('TIPOSDOCUMENTOS', 'TIPOSDOCUMENTOS.TIDO_ID', '=', 'PROSPECTOS.TIDO_ID')
			->join('CASOSMEDICOS', 'CASOSMEDICOS.CONT_ID', '=', 'CONTRATOS.CONT_ID')
			->join('DIAGNOSTICOSGENERALES', 'DIAGNOSTICOSGENERALES.DIGE_ID', '=', 'CASOSMEDICOS.DIGE_ID')
			->join('ESTADOSRESTRICCION', 'ESTADOSRESTRICCION.ESRE_ID', '=', 'CASOSMEDICOS.ESRE_ID')
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
			->join('GRUPOS', 'GRUPOS.GRUP_ID', '=', 'CONTRATOS.GRUP_ID')
			->leftJoin('GRUPOS_RESPONSABLES', 'GRUPOS_RESPONSABLES.GRUP_ID', '=', 'GRUPOS.GRUP_ID')
			->leftJoin('PROSPECTOS AS GRUPORESPONSABLE', 'GRUPORESPONSABLE.PROS_ID', '=', 'GRUPOS_RESPONSABLES.PROS_ID')
			->join('TURNOS', 'TURNOS.TURN_ID', '=', 'CONTRATOS.TURN_ID')
			->join('CIUDADES AS CIUDADES_CONTRATA', 'CIUDADES_CONTRATA.CIUD_ID', '=', 'CONTRATOS.CIUD_CONTRATA')
			->join('CIUDADES AS CIUDADES_SERVICIO', 'CIUDADES_SERVICIO.CIUD_ID', '=', 'CONTRATOS.CIUD_SERVICIO')
			->select([
				'EMPLEADORES.EMPL_NOMBRECOMERCIAL as EMPRESA',
				'GERENCIAS.GERE_DESCRIPCION AS GERENCIA',
				'CENTROSCOSTOS.CECO_CODIGO AS CCOSTO',
				'CENTROSCOSTOS.CECO_DESCRIPCION AS CENTRO_COSTO',
				'TEMPORALES.TEMP_NOMBRECOMERCIAL as E.S.T',
				'TIPOSCONTRATOS.TICO_DESCRIPCION as TIPO_CONTRATO',
				'CLASESCONTRATOS.CLCO_DESCRIPCION as CLASE_CONTRATO',
				'TIPOSDOCUMENTOS.TIDO_DESCRIPCION as TIPO_DOCUMENTO',
				'PROSPECTOS.PROS_CEDULA as CEDULA',
				expression_concat([
					'PROS_PRIMERAPELLIDO',
					'PROS_SEGUNDOAPELLIDO',
					'PROS_PRIMERNOMBRE',
					'PROS_SEGUNDONOMBRE'
				], 'NOMBRE_EMPLEADO', 'PROSPECTOS'),
				'CARGOS.CARG_DESCRIPCION AS CARGO',
				'DIGE_DESCRIPCION AS DIAGNOSTICO_GENERAL',
				'CAME_DIAGESPECIFICO AS DIAGNOSTICO_ESPECIFICO',
				'CAME_CONTINGENCIA AS CONTINGENCIA',
				'CAME_FECHARESTRICCION AS FECHA_RESTRICCION',
				'ESRE_DESCRIPCION AS ESTADO_RESTRICCION',
				'CAME_LUGARREUBICACION AS LUGAR_REUBICACION',
				'CAME_LABOR AS LABOR',
				'CAME_SEVERIDAD AS INDICADOR_SEVERIDAD',
				'CAME_FECHAACCIDENTE AS FECHA_ACCIDENTE',
				'CAME_ESTADO AS ESTADO_RM',
				'GRUP_DESCRIPCION AS GRUPO',
				'TURN_DESCRIPCION AS TURNO',
				expression_concat([
					'PROS_PRIMERAPELLIDO',
					'PROS_SEGUNDOAPELLIDO',
					'PROS_PRIMERNOMBRE',
					'PROS_SEGUNDONOMBRE'
				], 'GRUPO_RESPONSABLE', 'GRUPORESPONSABLE'),
				'CAME_PCL AS PCL',
				'CAME_NIVELPRODUCTIVIDAD AS NIVEL_PRODUCTIVIDAD',
				\DB::raw($sqlCantContratos),
				'PROSPECTOS.PROS_FECHANACIMIENTO AS FECHA_NACIMIENTO',
				'CONTRATOS.CONT_SALARIO AS SALARIO',
				'CAME_OBSERVACIONES AS OBSERVACIONES',
				'ESTADOSCONTRATOS.ESCO_DESCRIPCION AS ESTADO',
				'CONTRATOS.CONT_FECHAINGRESO AS FECHA_INGRESO',
				'CONTRATOS.CONT_FECHATERMINACION AS FECHA_FIN_CONTRATO',
				'CONTRATOS.CONT_FECHARETIRO AS FECHA_RETIRO',
				'CONTRATOS.CONT_FECHAGRABARETIRO AS FECHA_GRABA_RETIRO',
				'MOTIVOSRETIROS.MORE_DESCRIPCION AS MOTIVO_RETIRO',
				'CONTRATOS.CONT_VARIABLE AS VARIABLE',
				'CONTRATOS.CONT_RODAJE AS RODAJE',
				'TIPOSEMPLEADORES.TIEM_DESCRIPCION AS TIPO_EMPLEADOR',
				'RIESGOS.RIES_DESCRIPCION AS RIESGO',
				'NEGOCIOS.NEGO_DESCRIPCION AS NEGOCIO',
				'GRUPOS.GRUP_DESCRIPCION AS GRUPO_EMPLEADO',
				'TURNOS.TURN_DESCRIPCION AS TURNO_EMPLEADO',
				'PROSPECTOS.PROS_SEXO as SEXO',
				'CONTRATOS.CONT_CASOMEDICO AS CASO_MEDICO',
				'CIUDADES_CONTRATA.CIUD_NOMBRE AS CIUDAD_CONTRATO',
				'CIUDADES_SERVICIO.CIUD_NOMBRE AS CIUDAD_SERVICIO',
				'CONTRATOS.CONT_OBSERVACIONES AS OBSERVACIONES_CONTRATO',
				'CONTRATOS.CONT_MOREOBSERVACIONES AS OBSERVACIONES_RETIRO',
			])
			->where('CONTRATOS.CONT_CASOMEDICO', '=', 'SI')
			->whereNull('CONTRATOS.CONT_FECHAELIMINADO')
			->whereNull('CASOSMEDICOS.CAME_FECHAELIMINADO')
			->orderBy('EMPRESA', 'asc')
			->orderBy('GERENCIA', 'asc')
			->orderBy('CENTRO_COSTO', 'asc')
			->orderBy('CARGO', 'asc');

			//hace la consulta con base en los permisos asignados
			$query = get_permisosgenerales(\Auth::user()->id, $query);

		return $query;
	}

	private function getQueryNovedadesRm()
	{
		
		$query = Contrato::leftJoin('TEMPORALES', 'TEMPORALES.TEMP_ID', '=', 'CONTRATOS.TEMP_ID')
			->leftJoin('MOTIVOSRETIROS', 'MOTIVOSRETIROS.MORE_ID', '=', 'CONTRATOS.MORE_ID')
			->leftJoin('PROSPECTOS AS JEFES', 'JEFES.PROS_ID', '=', 'CONTRATOS.JEFE_ID')
			->leftJoin('PROSPECTOS AS REMPLAZOS', 'REMPLAZOS.PROS_ID', '=', 'CONTRATOS.REMP_ID')
			->join('PROSPECTOS', 'PROSPECTOS.PROS_ID', '=', 'CONTRATOS.PROS_ID')
			->join('CASOSMEDICOS', 'CASOSMEDICOS.CONT_ID', '=', 'CONTRATOS.CONT_ID')
			->join('DIAGNOSTICOSGENERALES', 'DIAGNOSTICOSGENERALES.DIGE_ID', '=', 'CASOSMEDICOS.DIGE_ID')
			->join('ESTADOSRESTRICCION', 'ESTADOSRESTRICCION.ESRE_ID', '=', 'CASOSMEDICOS.ESRE_ID')
			->join('NOVEDADESMEDICAS', 'NOVEDADESMEDICAS.CAME_ID', '=', 'CASOSMEDICOS.CAME_ID')
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
			->join('GRUPOS', 'GRUPOS.GRUP_ID', '=', 'CONTRATOS.GRUP_ID')
			->join('TURNOS', 'TURNOS.TURN_ID', '=', 'CONTRATOS.TURN_ID')
			->join('CIUDADES AS CIUDADES_CONTRATA', 'CIUDADES_CONTRATA.CIUD_ID', '=', 'CONTRATOS.CIUD_CONTRATA')
			->join('CIUDADES AS CIUDADES_SERVICIO', 'CIUDADES_SERVICIO.CIUD_ID', '=', 'CONTRATOS.CIUD_SERVICIO')
			->select([
				'EMPLEADORES.EMPL_NOMBRECOMERCIAL as EMPRESA',
				'GERENCIAS.GERE_DESCRIPCION AS GERENCIA',
				'CENTROSCOSTOS.CECO_CODIGO AS CCOSTO',
				'CENTROSCOSTOS.CECO_DESCRIPCION AS CENTRO_COSTO',
				'TEMPORALES.TEMP_NOMBRECOMERCIAL as E.S.T',
				'TIPOSCONTRATOS.TICO_DESCRIPCION as TIPO_CONTRATO',
				'CLASESCONTRATOS.CLCO_DESCRIPCION as CLASE_CONTRATO',
				'PROSPECTOS.PROS_CEDULA as CEDULA',
				expression_concat([
					'PROS_PRIMERAPELLIDO',
					'PROS_SEGUNDOAPELLIDO',
					'PROS_PRIMERNOMBRE',
					'PROS_SEGUNDONOMBRE'
				], 'NOMBRE_EMPLEADO', 'PROSPECTOS'),
				'CARG_DESCRIPCION AS CARGO',
				'ESTADOSCONTRATOS.ESCO_DESCRIPCION AS ESTADO',
				'CAME_FECHARESTRICCION AS FECHA_RESTRICCION',
				'ESRE_DESCRIPCION AS ESTADO_RESTRICCION',
				'NOME_FECHANOVEDAD AS FECHA_NOVEDAD',
				'NOME_DESCRIPCION AS DESCRIPCION_NOVEDAD',
				'NOME_OBSERVACIONES AS OBSERVACIONES_NOVEDAD'
				
			])
			->whereNull('CONTRATOS.CONT_FECHAELIMINADO')
			->whereNull('CASOSMEDICOS.CAME_FECHAELIMINADO')
			->whereNull('NOVEDADESMEDICAS.NOME_FECHAELIMINADO')
			->orderBy('EMPRESA', 'asc')
			->orderBy('GERENCIA', 'asc')
			->orderBy('CENTRO_COSTO', 'asc')
			->orderBy('CARGO', 'asc');

			//hace la consulta con base en los permisos asignados
			$query = get_permisosgenerales(\Auth::user()->id, $query);

		return $query;
	}

	private function getQueryActivosPlantilla()
	{
		$query = Contrato::leftJoin('TEMPORALES', 'TEMPORALES.TEMP_ID', '=', 'CONTRATOS.TEMP_ID')
			->leftJoin('MOTIVOSRETIROS', 'MOTIVOSRETIROS.MORE_ID', '=', 'CONTRATOS.MORE_ID')
			->leftJoin('PROSPECTOS AS JEFES', 'JEFES.PROS_ID', '=', 'CONTRATOS.JEFE_ID')
			->leftJoin('PROSPECTOS AS REMPLAZOS', 'REMPLAZOS.PROS_ID', '=', 'CONTRATOS.REMP_ID')
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
			->join('GRUPOS', 'GRUPOS.GRUP_ID', '=', 'CONTRATOS.GRUP_ID')
			->join('TURNOS', 'TURNOS.TURN_ID', '=', 'CONTRATOS.TURN_ID')
			->join('CIUDADES AS CIUDADES_CONTRATA', 'CIUDADES_CONTRATA.CIUD_ID', '=', 'CONTRATOS.CIUD_CONTRATA')
			->join('CIUDADES AS CIUDADES_SERVICIO', 'CIUDADES_SERVICIO.CIUD_ID', '=', 'CONTRATOS.CIUD_SERVICIO')
			->select([
				'EMPLEADORES.EMPL_NOMBRECOMERCIAL as EMPRESA',
				'TEMPORALES.TEMP_NOMBRECOMERCIAL as E.S.T',
				'ESTADOSCONTRATOS.ESCO_DESCRIPCION AS ESTADO',
				'NEGOCIOS.NEGO_DESCRIPCION AS NEGOCIO',
				'GERENCIAS.GERE_DESCRIPCION AS GERENCIA',
				'CENTROSCOSTOS.CECO_CODIGO AS CCOSTO',
				'CENTROSCOSTOS.CECO_DESCRIPCION AS CENTRO_COSTO',
				expression_concat([
					'PROS_PRIMERAPELLIDO',
					'PROS_SEGUNDOAPELLIDO',
					'PROS_PRIMERNOMBRE',
					'PROS_SEGUNDONOMBRE'
				], 'NOMBRE_EMPLEADO', 'PROSPECTOS'),
				'CARGOS.CARG_DESCRIPCION AS CARGO',
				'PROSPECTOS.PROS_CEDULA as CEDULA',
				'CONTRATOS.CONT_ID AS CODIGO',
				'CONTRATOS.CONT_FECHAINGRESO AS FECHA_INGRESO',
				'CONTRATOS.CONT_SALARIO AS SALARIO',
			])
			->whereNull('CONTRATOS.CONT_FECHAELIMINADO');

			//hace la consulta con base en los permisos asignados
			$query = get_permisosgenerales(\Auth::user()->id, $query);

		return $query;
	}

	private function getQueryOperaciones()
	{

		$query = Contrato::leftJoin('TEMPORALES', 'TEMPORALES.TEMP_ID', '=', 'CONTRATOS.TEMP_ID')
			->leftJoin('MOTIVOSRETIROS', 'MOTIVOSRETIROS.MORE_ID', '=', 'CONTRATOS.MORE_ID')
			->leftJoin('PROSPECTOS AS JEFES', 'JEFES.PROS_ID', '=', 'CONTRATOS.JEFE_ID')
			->leftJoin('PROSPECTOS AS REMPLAZOS', 'REMPLAZOS.PROS_ID', '=', 'CONTRATOS.REMP_ID')
			->join('PROSPECTOS', 'PROSPECTOS.PROS_ID', '=', 'CONTRATOS.PROS_ID')
			->leftJoin('BANCOS', 'BANCOS.BANC_ID', '=', 'PROSPECTOS.BANC_ID')	
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
			->join('GRUPOS', 'GRUPOS.GRUP_ID', '=', 'CONTRATOS.GRUP_ID')
			->leftJoin('GRUPOS_RESPONSABLES', 'GRUPOS_RESPONSABLES.GRUP_ID', '=', 'GRUPOS.GRUP_ID')
			->leftJoin('PROSPECTOS AS GRUPORESPONSABLE', 'GRUPORESPONSABLE.PROS_ID', '=', 'GRUPOS_RESPONSABLES.PROS_ID')
			->join('TURNOS', 'TURNOS.TURN_ID', '=', 'CONTRATOS.TURN_ID')
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
				'CONTRATOS.CONT_FECHARETIRO AS FECHA_RETIRO',
				'GERENCIAS.GERE_DESCRIPCION AS GERENCIA',
				'CENTROSCOSTOS.CECO_CODIGO AS CCOSTO',
				'CENTROSCOSTOS.CECO_DESCRIPCION AS CENTRO_COSTO',
				'GRUPOS.GRUP_DESCRIPCION AS GRUPO_EMPLEADO',
				'TURNOS.TURN_DESCRIPCION AS TURNO_EMPLEADO',
				expression_concat([
					'PROS_PRIMERAPELLIDO',
					'PROS_SEGUNDOAPELLIDO',
					'PROS_PRIMERNOMBRE',
					'PROS_SEGUNDONOMBRE'
				], 'GRUPO_RESPONSABLE', 'GRUPORESPONSABLE'),
				'PROSPECTOS.PROS_SEXO AS SEXO',
				expression_concat([
					'PROS_PRIMERAPELLIDO',
					'PROS_SEGUNDOAPELLIDO',
					'PROS_PRIMERNOMBRE',
					'PROS_SEGUNDONOMBRE'
				], 'JEFE_INMEDIATO', 'JEFES'),
				expression_concat([
					'PROS_PRIMERAPELLIDO',
					'PROS_SEGUNDOAPELLIDO',
					'PROS_PRIMERNOMBRE',
					'PROS_SEGUNDONOMBRE'
				], 'REMPLAZA_A', 'REMPLAZOS'),
			])
			->whereIn('ESTADOSCONTRATOS.ESCO_ID', [EstadoContrato::ACTIVO, EstadoContrato::VACACIONES])
			->whereNull('CONTRATOS.CONT_FECHAELIMINADO')
			->orderBy('EMPRESA', 'asc')
			->orderBy('GERENCIA', 'asc')
			->orderBy('CENTRO_COSTO', 'asc')
			->orderBy('CARGO', 'asc');

		//hace la consulta con base en los permisos asignados
		$query = get_permisosgenerales(\Auth::user()->id, $query, 'reporte');

		return $query;
	}

	private function getQuerySeguridadSocial()
	{
        //Subquery para Postgres para AFP
		$sqlAfp = '(SELECT "ENTIDADES"."ENTI_CODIGO"'.
			'FROM "ENTIDADES"
			JOIN "CONTRATO_ENTIDAD"
				ON "CONTRATO_ENTIDAD"."ENTI_ID" = "ENTIDADES"."ENTI_ID"
			JOIN "CONTRATOS" AS "CON"
				ON "CON"."CONT_ID" = "CONTRATO_ENTIDAD"."CONT_ID"
			WHERE "ENTIDADES"."TIEN_ID" =' . TipoEntidad::AFP .
			' AND "CON"."CONT_ID" = "CONTRATOS"."CONT_ID"' .
			') AS "FONDO_PENSIONES"';

		if(config('database.default') == 'mysql'){
    		$sqlAfp = str_replace('"', '', $sqlAfp);
        }

        //Subquery para Postgres para EPS
		$sqlEps= '(SELECT "ENTI_CODIGO"' . 
			'FROM "ENTIDADES"
			JOIN "CONTRATO_ENTIDAD"
				ON "CONTRATO_ENTIDAD"."ENTI_ID" = "ENTIDADES"."ENTI_ID"
			JOIN "CONTRATOS" AS "CON"
				ON "CON"."CONT_ID" = "CONTRATO_ENTIDAD"."CONT_ID"
			WHERE "ENTIDADES"."TIEN_ID" =' . TipoEntidad::EPS .
			' AND "CON"."CONT_ID" = "CONTRATOS"."CONT_ID"' .
			') AS "EPS"';

		if(config('database.default') == 'mysql'){
    		$sqlEps = str_replace('"', '', $sqlEps);
        }

        //Subquery para Postgres para ARL
		$sqlCcf = '(SELECT "ENTIDADES"."ENTI_CODIGO"' . 
			'FROM "ENTIDADES"
			JOIN "CONTRATO_ENTIDAD"
				ON "CONTRATO_ENTIDAD"."ENTI_ID" = "ENTIDADES"."ENTI_ID"
			JOIN "CONTRATOS" AS "CON"
				ON "CON"."CONT_ID" = "CONTRATO_ENTIDAD"."CONT_ID"
			WHERE "ENTIDADES"."TIEN_ID" =' . TipoEntidad::CCF .
			' AND "CON"."CONT_ID" = "CONTRATOS"."CONT_ID"' .
			') AS "CCF"';

		if(config('database.default') == 'mysql'){
    		$sqlCcf = str_replace('"', '', $sqlCcf);
        }

		$query = Contrato::leftJoin('TEMPORALES', 'TEMPORALES.TEMP_ID', '=', 'CONTRATOS.TEMP_ID')
			->join('PROSPECTOS', 'PROSPECTOS.PROS_ID', '=', 'CONTRATOS.PROS_ID')
			->join('GERENCIAS', 'GERENCIAS.GERE_ID', '=', 'CONTRATOS.GERE_ID')
			->join('TIPOSDOCUMENTOS', 'TIPOSDOCUMENTOS.TIDO_ID', '=', 'PROSPECTOS.TIDO_ID')		
			->join('EMPLEADORES', 'EMPLEADORES.EMPL_ID', '=', 'CONTRATOS.EMPL_ID')
			->join('ESTADOSCONTRATOS', 'ESTADOSCONTRATOS.ESCO_ID', '=', 'CONTRATOS.ESCO_ID')
			->join('RIESGOS', 'RIESGOS.RIES_ID', '=', 'CONTRATOS.RIES_ID')
			->select([
				'EMPLEADORES.EMPL_NOMBRECOMERCIAL as EMPRESA',
				'TIPOSDOCUMENTOS.TIDO_DESCRIPCION AS TIPO_DOCUMENTO',
				'PROSPECTOS.PROS_CEDULA AS CEDULA',
				'PROSPECTOS.PROS_PRIMERAPELLIDO AS PRIMER_APELLIDO',
				'PROSPECTOS.PROS_SEGUNDOAPELLIDO AS SEGUNDO_APELLIDO',
				'PROSPECTOS.PROS_PRIMERNOMBRE AS PRIMER_NOMBRE',
				'PROSPECTOS.PROS_SEGUNDONOMBRE AS SEGUNDO_NOMBRE',
				'CONTRATOS.CONT_FECHAINGRESO AS FECHA_INGRESO',
				'CONTRATOS.CONT_FECHARETIRO AS FECHA_RETIRO',
				\DB::raw($sqlAfp),
				\DB::raw($sqlEps),
				\DB::raw($sqlCcf),
				'CONTRATOS.CONT_SALARIO AS SALARIO',
				'RIESGOS.RIES_ID AS RIESGO',
				'ESTADOSCONTRATOS.ESCO_DESCRIPCION AS ESTADO_CONTRATO'
			])
			->whereNull('CONTRATOS.CONT_FECHAELIMINADO')
			->where('CONTRATOS.TICO_ID', TipoContrato::DIRECTO);

			//hace la consulta con base en los permisos asignados
			$query = get_permisosgenerales(\Auth::user()->id, $query);

		return $query;
	}

	private function getQueryIndicadorRotacion()
	{
		//parametro general que identifica los motivos de retiro que se deben excluir del indicador de rotacion
		//PAGE_DESCRIPCION = MOT_RETIRO_EXCLUIDOS_INDICADOR
		$parametroindicador = ParametroGeneral::findOrFail(3);
		$parametroindicador = explode(',', $parametroindicador->PAGE_VALOR);

		//dd($parametroindicador);

		$query = MotivoRetiro::select([
			])
		->whereNotIn('MOTIVOSRETIROS.MORE_ID', $parametroindicador);

		return $query;
	}

	/**
	 * 
	 *
	 * @return Json
	 */
	public function contratosActivos()
	{
		$query = $this->getQuery()
					->whereIn('ESTADOSCONTRATOS.ESCO_ID', [EstadoContrato::ACTIVO, EstadoContrato::VACACIONES]);

		if(isset($this->data['fchaIngresoDesde']))
			$query->whereDate('CONT_FECHAINGRESO', '>=', Carbon::parse($this->data['fchaIngresoDesde']));
		if(isset($this->data['fchaIngresoHasta']))
			$query->whereDate('CONT_FECHAINGRESO', '<=', Carbon::parse($this->data['fchaIngresoHasta']));
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
		if(isset($this->data['grupo']))
			$query->where('CONTRATOS.GRUP_ID', '=', $this->data['grupo']);
		if(isset($this->data['turno']))
			$query->where('CONTRATOS.TURN_ID', '=', $this->data['turno']);
		if(isset($this->data['prospecto']))
			$query->where('PROSPECTOS.PROS_CEDULA', '=', $this->data['prospecto']);
		if(isset($this->data['negocio']))
			$query->where('CONTRATOS.NEGO_ID', '=', $this->data['negocio']);

		return $this->buildJson($query);
	}

	/**
	 * 
	 * Retorna un listado básico de personal para que operaciones pueda constatar con que personal cuenta
	 * @return Json
	 */
	public function contratosOperaciones()
	{
		$query = $this->getQueryOperaciones();

		if(isset($this->data['fchaIngresoDesde']))
			$query->whereDate('CONT_FECHAINGRESO', '>=', Carbon::parse($this->data['fchaIngresoDesde']));
		if(isset($this->data['fchaIngresoHasta']))
			$query->whereDate('CONT_FECHAINGRESO', '<=', Carbon::parse($this->data['fchaIngresoHasta']));
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
		if(isset($this->data['grupo']))
			$query->where('CONTRATOS.GRUP_ID', '=', $this->data['grupo']);
		if(isset($this->data['turno']))
			$query->where('CONTRATOS.TURN_ID', '=', $this->data['turno']);
		if(isset($this->data['prospecto']))
			$query->where('PROSPECTOS.PROS_CEDULA', '=', $this->data['prospecto']);
		if(isset($this->data['negocio']))
			$query->where('CONTRATOS.NEGO_ID', '=', $this->data['negocio']);

		return $this->buildJson($query);
	}


	/**
	 * 
	 * Retorna un listado  de personal sin Turno o Grupo para Operaciones
	 * @return Json
	 */
	public function contratosOperacionesSinClasificacion()
	{
		//$query = $this->getQueryOperaciones();

		$query = $this->getQueryOperaciones()
						->where(function($query){
							$query->where('CONTRATOS.TURN_ID', Turno::SIN_TURNO)
								->orWhere('CONTRATOS.GRUP_ID', Grupo::SIN_GRUPO)
								->orWhereNull('CONTRATOS.JEFE_ID');
							});
					//->whereIn('TURNOS.TURN_ID', [Turno::SIN_TURNO])
					//->orWhereIn('GRUPOS.GRUP_ID', [Grupo::SIN_GRUPO]);

		if(isset($this->data['fchaIngresoDesde']))
			$query->whereDate('CONT_FECHAINGRESO', '>=', Carbon::parse($this->data['fchaIngresoDesde']));
		if(isset($this->data['fchaIngresoHasta']))
			$query->whereDate('CONT_FECHAINGRESO', '<=', Carbon::parse($this->data['fchaIngresoHasta']));
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
		if(isset($this->data['grupo']))
			$query->where('CONTRATOS.GRUP_ID', '=', $this->data['grupo']);
		if(isset($this->data['turno']))
			$query->where('CONTRATOS.TURN_ID', '=', $this->data['turno']);
		if(isset($this->data['prospecto']))
			$query->where('PROSPECTOS.PROS_CEDULA', '=', $this->data['prospecto']);
		if(isset($this->data['negocio']))
			$query->where('CONTRATOS.NEGO_ID', '=', $this->data['negocio']);

		return $this->buildJson($query);
	}


	/**
	 * 
	 *
	 * @return Json
	 */
	public function historicoContratos()
	{
		$query = $this->getQuery();

		if(isset($this->data['fchaIngresoDesde']))
			$query->whereDate('CONT_FECHAINGRESO', '>=', Carbon::parse($this->data['fchaIngresoDesde']));
		if(isset($this->data['fchaIngresoHasta']))
			$query->whereDate('CONT_FECHAINGRESO', '<=', Carbon::parse($this->data['fchaIngresoHasta']));
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
			$query->where('CONTRATOS.GRUP_ID', '=', $this->data['grupo']);
		if(isset($this->data['estado']))
			$query->where('CONTRATOS.ESCO_ID', '=', $this->data['estado']);
		if(isset($this->data['turno']))
			$query->where('CONTRATOS.TURN_ID', '=', $this->data['turno']);
		if(isset($this->data['prospecto']))
			$query->where('PROSPECTOS.PROS_CEDULA', '=', $this->data['prospecto']);

		return $this->buildJson($query);
	}

	/**
	 * 
	 *
	 * @return Json
	 */
	public function activosPorPeriodo()
	{
		$query = $this->getQuery()
			//Solución #1 cuando el empleado se encuentra retirado (fecha de retiro diferente de nulo):
			//(CONT_FECHAINGRESO <= fchaIngresoDesde) AND (CONT_FECHARETIRO >= fchaIngresoDesde) AND (CONT_FECHARETIRO >= fchaIngresoHasta)
			->where(function($query){
				$query->where('ESTADOSCONTRATOS.ESCO_ID', EstadoContrato::RETIRADO)
					->where('CONTRATOS.EMPL_ID', $this->data['empresa'])
					->whereDate('CONT_FECHAINGRESO', '<=', Carbon::parse($this->data['fchaIngresoDesde']))
					->whereDate('CONT_FECHARETIRO', '>=', Carbon::parse($this->data['fchaIngresoDesde']))
					->whereDate('CONT_FECHARETIRO', '>=', Carbon::parse($this->data['fchaIngresoHasta']));
			});

			$query = get_permisosgenerales(\Auth::user()->id, $query);
			//Solución #2 cuando el empleado se encuentra retirado (fecha de retiro diferente de nulo):
			//(CONT_FECHAINGRESO >= fchaIngresoDesde) AND (CONT_FECHAINGRESO <= fchaIngresoHasta) AND (CONT_FECHARETIRO >= fchaIngresoHasta)
			$query->orwhere(function($query){
				$query->where('ESTADOSCONTRATOS.ESCO_ID', EstadoContrato::RETIRADO)
					->where('CONTRATOS.EMPL_ID', $this->data['empresa'])
					->whereDate('CONT_FECHAINGRESO', '>=', Carbon::parse($this->data['fchaIngresoDesde']))
					->whereDate('CONT_FECHAINGRESO', '<=', Carbon::parse($this->data['fchaIngresoHasta']))
					->whereDate('CONT_FECHARETIRO', '>=', Carbon::parse($this->data['fchaIngresoHasta']));
			});

			$query = get_permisosgenerales(\Auth::user()->id, $query);


			//Solución #3 cuando el empleado se encuentra activo (fecha de retiro es nula):
			//((CONT_FECHAINGRESO <= fchaIngresoDesde) OR (CONT_FECHAINGRESO == fchaIngresoDesde)) AND (CONT_FECHAINGRESO <= fchaIngresoHasta)
			$query->orwhere(function($query){
				$query->whereIn('ESTADOSCONTRATOS.ESCO_ID', [EstadoContrato::ACTIVO,EstadoContrato::VACACIONES])
					->where('CONTRATOS.EMPL_ID', $this->data['empresa'])
					->whereDate('CONT_FECHAINGRESO', '<=', Carbon::parse($this->data['fchaIngresoHasta']))
					->where(function($query){
						$query->orWhereDate('CONT_FECHAINGRESO', '<=', Carbon::parse($this->data['fchaIngresoDesde']))
							->orWhereDate('CONT_FECHAINGRESO', '=', Carbon::parse($this->data['fchaIngresoDesde']));
					});
			});

			$query = get_permisosgenerales(\Auth::user()->id, $query);

		//hace la consulta con base en los permisos asignados
		

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
			$query->where('CONTRATOS.GRUP_ID', '=', $this->data['grupo']);
		if(isset($this->data['estado']))
			$query->where('CONTRATOS.ESCO_ID', '=', $this->data['estado']);
		if(isset($this->data['turno']))
			$query->where('CONTRATOS.TURN_ID', '=', $this->data['turno']);
		if(isset($this->data['negocio']))
			$query->where('CONTRATOS.NEGO_ID', '=', $this->data['negocio']);


		return $this->buildJson($query);
	}

	/**
	 * 
	 *
	 * @return Json
	 */
	public function indicadorDeRotacion()
	{

		$fecha = Carbon::create($this->data['anio'], $this->data['mes'])->endOfMonth()->toDateString();
		$fecha = "'".$fecha."'";
		//dd($fecha);
		$fechaini = Carbon::create($this->data['anio'], $this->data['mes'])->startOfMonth()->toDateString();
		$fechaini = "'".$fechaini."'";


		//Subquery para Postgres para determinar el nombre del mes
		$sqlMes = '(SELECT TO_CHAR(DATE' . $fecha . ','."'"."TMMONTH"."'".')
		) AS "MES"';

		//Subquery para Postgres para determinar el empleador
		$sqlEmpleador = '(SELECT "EMPL_RAZONSOCIAL" FROM "EMPLEADORES"
			WHERE "EMPLEADORES"."EMPL_ID" = ' . $this->data['empresa'] . '
		) AS "EMPRESA"';


		$sqlActPeriodo = '(SELECT 
								COUNT(*) 
					FROM "CONTRATOS"
			WHERE 	"CONTRATOS"."EMPL_ID" = ' . $this->data['empresa'] . ' 
			AND 	"CONTRATOS"."CONT_FECHAELIMINADO" IS NULL
			AND 	(
					"CONTRATOS"."ESCO_ID" = 3' .'
						AND "CONT_FECHAINGRESO" <= DATE(' . $fecha . ') 
						AND "CONT_FECHARETIRO" >= DATE(' . $fecha  . ')
						AND "CONT_FECHARETIRO" >= DATE(' . $fecha  . ')
			)

			OR ( "CONTRATOS"."ESCO_ID" = 3
				AND 	"CONTRATOS"."EMPL_ID" = ' . $this->data['empresa'] . ' 
				AND "CONT_FECHAINGRESO" >= DATE(' . $fecha  . ')
				AND "CONT_FECHAINGRESO" <= DATE('. $fecha  . ')
				AND "CONT_FECHARETIRO" >= DATE('. $fecha  . '))' . 

			'
			OR ( "CONTRATOS"."ESCO_ID" in ( 1,2' .') '.'
				AND 	"CONTRATOS"."EMPL_ID" = ' . $this->data['empresa'] . ' 
				AND "CONT_FECHAINGRESO" <= DATE(' . $fecha .  ')
				AND ( "CONT_FECHAINGRESO" <= DATE(' . $fecha . ')
				OR "CONT_FECHAINGRESO" = DATE(' . $fecha . ')))
			' . ') AS "ACTIVOS_PERIODO"';

		$sqlRetiroPeriodo = '(SELECT
								COUNT(*) 
					FROM "CONTRATOS"
			INNER JOIN "MOTIVOSRETIROS" AS "MR"
				ON 	"MOTIVOSRETIROS"."MORE_ID" = "CONTRATOS"."MORE_ID"
			WHERE "ESCO_ID" = 3
			AND   "CONTRATOS"."EMPL_ID" = ' . $this->data['empresa'] . ' 
			AND 	(
						"CONT_FECHARETIRO" >= DATE(' . $fechaini  . ')
						AND "CONT_FECHARETIRO" <= DATE(' . $fecha  . ')
			)'
			.
			' AND "MOTIVOSRETIROS"."MORE_ID" = "MR"."MORE_ID"
			' . ') AS "RETIRADOS_PERIODO"';

		$sqlIndicador	= 'ROUND(((SELECT
								COUNT(*) 
					FROM "CONTRATOS"
			INNER JOIN "MOTIVOSRETIROS" AS "MR"
				ON 	"MOTIVOSRETIROS"."MORE_ID" = "CONTRATOS"."MORE_ID"
			WHERE "ESCO_ID" = 3
			AND   "CONTRATOS"."EMPL_ID" = ' . $this->data['empresa'] . ' 
			AND 	(
						"CONT_FECHARETIRO" >= DATE(' . $fechaini  . ')
						AND "CONT_FECHARETIRO" <= DATE(' . $fecha  . ')
			)'
			.
			' AND "MOTIVOSRETIROS"."MORE_ID" = "MR"."MORE_ID"
			' . ') / '
			. '(SELECT 
								COUNT(*) 
					FROM "CONTRATOS"
			WHERE 	"CONTRATOS"."EMPL_ID" = ' . $this->data['empresa'] . ' 
			AND 	"CONTRATOS"."CONT_FECHAELIMINADO" IS NULL
			AND 	(
					"CONTRATOS"."ESCO_ID" = 3' .'
						AND "CONT_FECHAINGRESO" <= DATE(' . $fecha . ') 
						AND "CONT_FECHARETIRO" >= DATE(' . $fecha  . ')
						AND "CONT_FECHARETIRO" >= DATE(' . $fecha  . ')
			)

			OR ( "CONTRATOS"."ESCO_ID" = 3
				AND 	"CONTRATOS"."EMPL_ID" = ' . $this->data['empresa'] . '
				AND "CONT_FECHAINGRESO" >= DATE(' . $fecha  . ')
				AND "CONT_FECHAINGRESO" <= DATE('. $fecha  . ')
				AND "CONT_FECHARETIRO" >= DATE('. $fecha  . '))' . 

			'
			OR ( "CONTRATOS"."ESCO_ID" in ( 1,2' .') '.'
				AND 	"CONTRATOS"."EMPL_ID" = ' . $this->data['empresa'] . '
				AND "CONT_FECHAINGRESO" <= DATE(' . $fecha .  ')
				AND ( "CONT_FECHAINGRESO" <= DATE(' . $fecha . ')
				OR "CONT_FECHAINGRESO" = DATE(' . $fecha . ')))
			' . ')::numeric)*100,2) || ' . "'"."%"."'" . ' AS "INDICADOR"';

		//En Mysql, el query no debe tener comillas dobles.
        if(config('database.default') == 'mysql'){
    		$sqlEmpleador = str_replace('"', '', $sqlEmpleador);
    		$sqlMes = str_replace('"', '', $sqlMes);
    		$sqlActPeriodo = str_replace('"', '', $sqlActPeriodo);
    		$sqlRetiroPeriodo = str_replace('"', '', $sqlRetiroPeriodo);
    		$sqlIndicador = str_replace('"', '', $sqlIndicador);
        }

		$query = $this->getQueryIndicadorRotacion()
					->addSelect([
						\DB::raw($sqlEmpleador),
						\DB::raw($sqlMes),
						'MOTIVOSRETIROS.MORE_DESCRIPCION AS MOTIVO_RETIRO',
						\DB::raw($sqlActPeriodo),
						\DB::raw($sqlRetiroPeriodo),
						\DB::raw($sqlIndicador),
					]);

		return $this->buildJson($query);
	}

	/**
	 * 
	 *
	 * @return Json
	 */
	public function indicadorDeRotacionTotal()
	{
		//parametro general que identifica los motivos de retiro que se deben excluir del indicador de rotacion
		//PAGE_DESCRIPCION = MOT_RETIRO_EXCLUIDOS_INDICADOR
		$parametroindicador = ParametroGeneral::findOrFail(3);

		$fecha = Carbon::create($this->data['anio'], $this->data['mes'])->endOfMonth()->toDateString();
		$fecha = "'".$fecha."'";
		//dd($fecha);
		$fechaini = Carbon::create($this->data['anio'], $this->data['mes'])->startOfMonth()->toDateString();
		$fechaini = "'".$fechaini."'";

		$sqlIndicador	= 'COALESCE( ROUND(((SELECT
								COUNT(*) 
					FROM "CONTRATOS"
			WHERE "ESCO_ID" = 3
			AND   "CONTRATOS"."EMPL_ID" = "EM"."EMPL_ID" ' . '
			AND   "MORE_ID" NOT IN (' . $parametroindicador->PAGE_VALOR  . ') 
			AND 	(
						"CONT_FECHARETIRO" >= DATE(' . $fechaini  . ')
						AND "CONT_FECHARETIRO" <= DATE(' . $fecha  . ')
			)'
			.
			'
			' . ') / NULLIF( '
			. '(SELECT 
								COUNT(*) 
					FROM "CONTRATOS"
			WHERE 	"CONTRATOS"."EMPL_ID" = "EM"."EMPL_ID" ' . '
			AND 	"CONTRATOS"."CONT_FECHAELIMINADO" IS NULL
			AND 	(
					"CONTRATOS"."ESCO_ID" = 3' .'
						AND "CONT_FECHAINGRESO" <= DATE(' . $fecha . ') 
						AND "CONT_FECHARETIRO" >= DATE(' . $fecha  . ')
						AND "CONT_FECHARETIRO" >= DATE(' . $fecha  . ')
			)

			OR ( "CONTRATOS"."ESCO_ID" = 3
				AND 	"CONTRATOS"."EMPL_ID" = "EM"."EMPL_ID" ' .  '
				AND "CONT_FECHAINGRESO" >= DATE(' . $fecha  . ')
				AND "CONT_FECHAINGRESO" <= DATE('. $fecha  . ')
				AND "CONT_FECHARETIRO" >= DATE('. $fecha  . '))' . 

			'
			OR ( "CONTRATOS"."ESCO_ID" in ( 1,2' .') '.'
				AND 	"CONTRATOS"."EMPL_ID" = "EM"."EMPL_ID" ' . '
				AND "CONT_FECHAINGRESO" <= DATE(' . $fecha .  ')
				AND ( "CONT_FECHAINGRESO" <= DATE(' . $fecha . ')
				OR "CONT_FECHAINGRESO" = DATE(' . $fecha . ')))
			' . ')::numeric , 0))*100,2), 0.00 )|| ' . "'"."%"."'" . ' AS "INDICADOR"';

		//En Mysql, el query no debe tener comillas dobles.
        if(config('database.default') == 'mysql'){
    		$sqlIndicador = str_replace('"', '', $sqlIndicador);
        }

		$query = $this->getQueryIndicadorRotacion()
					->join('EMPLEADORES AS EM','EM.EMPL_ID','=','EM.EMPL_ID')
					->addSelect([
						'EM.EMPL_NOMBRECOMERCIAL AS EMPRESA',
						\DB::raw($sqlIndicador),
					])
					->groupBy('EMPRESA','INDICADOR');
		//dd($query->toSql());
		return $this->buildJson($query);
	}

	/**
	 * 
	 *
	 * @return Json
	 */
	public function ingresosPorFecha()
	{
		$query = $this->getQuery()
			->whereIn('ESTADOSCONTRATOS.ESCO_ID', [EstadoContrato::ACTIVO,EstadoContrato::RETIRADO,EstadoContrato::VACACIONES]);

		if(isset($this->data['fchaIngresoDesde']))
			$query->whereDate('CONT_FECHAINGRESO', '>=', Carbon::parse($this->data['fchaIngresoDesde']));
		if(isset($this->data['fchaIngresoHasta']))
			$query->whereDate('CONT_FECHAINGRESO', '<=', Carbon::parse($this->data['fchaIngresoHasta']));
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
		if(isset($this->data['grupo']))
			$query->where('CONTRATOS.GRUP_ID', '=', $this->data['grupo']);
		if(isset($this->data['turno']))
			$query->where('CONTRATOS.TURN_ID', '=', $this->data['turno']);
		if(isset($this->data['prospecto']))
			$query->where('PROSPECTOS.PROS_CEDULA', '=', $this->data['prospecto']);
		if(isset($this->data['negocio']))
			$query->where('CONTRATOS.NEGO_ID', '=', $this->data['negocio']);

		return $this->buildJson($query);
	}

	/**
	 * 
	 *
	 * @return Json
	 */
	public function retirosPorFecha()
	{
		$query = $this->getQuery()
			->whereIn('ESTADOSCONTRATOS.ESCO_ID', [EstadoContrato::RETIRADO]);

		if(isset($this->data['fchaRetiroDesde']))
			$query->whereDate('CONT_FECHARETIRO', '>=', Carbon::parse($this->data['fchaRetiroDesde']));
		if(isset($this->data['fchaRetiroHasta']))
			$query->whereDate('CONT_FECHARETIRO', '<=', Carbon::parse($this->data['fchaRetiroHasta']));
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
			$query->where('CONTRATOS.GRUP_ID', '=', $this->data['grupo']);
		if(isset($this->data['turno']))
			$query->where('CONTRATOS.TURN_ID', '=', $this->data['turno']);
		if(isset($this->data['prospecto']))
			$query->where('PROSPECTOS.PROS_CEDULA', '=', $this->data['prospecto']);
		if(isset($this->data['negocio']))
			$query->where('CONTRATOS.NEGO_ID', '=', $this->data['negocio']);

		return $this->buildJson($query);
	}

	/**
	 * 
	 *
	 * @return Json
	 */
	public function historiaPorCedula()
	{
		$query = $this->getQuery();

		if(isset($this->data['prospecto']))
			$query->where('PROSPECTOS.PROS_CEDULA', '=', $this->data['prospecto']);

		return $this->buildJson($query);
	}


	/**
	 * 
	 *
	 * @return Json
	 */
	public function proximosTemporalidad()
	{
		$days = $this->data['dias']; //Se debe leer desde la parametrización del sistema
		$filterDate = Carbon::now()->subDays($days);

		$query = $this->getQuery()
			->whereIn('ESTADOSCONTRATOS.ESCO_ID', [EstadoContrato::ACTIVO, EstadoContrato::VACACIONES])
			->where('CONTRATOS.TICO_ID', TipoContrato::INDIRECTO)
			->where('CONTRATOS.CLCO_ID', ClaseContrato::OBRALABOR)
			->whereDate('CONT_FECHAINGRESO', '<=', $filterDate);

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
			$query->where('CONTRATOS.GRUP_ID', '=', $this->data['grupo']);
		if(isset($this->data['turno']))
			$query->where('CONTRATOS.TURN_ID', '=', $this->data['turno']);

		return $this->buildJson($query, $columnChart='E.S.T');
	}

	/**
	 * 
	 *
	 * @return Json
	 */
	public function proximosFinalizar()
	{
		$days = $this->data['dias']; 
		$filterDate = Carbon::now()->addDays($days);

		$query = $this->getQuery()
			->whereIn('ESTADOSCONTRATOS.ESCO_ID', [EstadoContrato::ACTIVO, EstadoContrato::VACACIONES])
			->where('CONTRATOS.TICO_ID', TipoContrato::DIRECTO)
			->where('CONTRATOS.CLCO_ID', ClaseContrato::FIJO)
			->whereDate('CONT_FECHATERMINACION', '<=', $filterDate);

		if(isset($this->data['empresa']))
			$query->where('CONTRATOS.EMPL_ID', '=', $this->data['empresa']);
		if(isset($this->data['gerencia']))
			$query->where('CONTRATOS.GERE_ID', '=', $this->data['gerencia']);
		if(isset($this->data['centrocosto']))
			$query->where('CONTRATOS.CECO_ID', '=', $this->data['centrocosto']);
		if(isset($this->data['cargo']))
			$query->where('CONTRATOS.CARG_ID', '=', $this->data['cargo']);
		if(isset($this->data['grupo']))
			$query->where('CONTRATOS.GRUP_ID', '=', $this->data['grupo']);
		if(isset($this->data['turno']))
			$query->where('CONTRATOS.TURN_ID', '=', $this->data['turno']);

		return $this->buildJson($query, $columnChart='E.S.T');
	}


	/**
	 * 
	 *
	 * @return Json
	 */
	public function headcountRm()
	{
		$query = $this->getQueryRm()
			->whereIn('ESTADOSCONTRATOS.ESCO_ID', [EstadoContrato::ACTIVO, EstadoContrato::VACACIONES]);

		if(isset($this->data['fchaIngresoDesde']))
			$query->whereDate('CONT_FECHAINGRESO', '>=', Carbon::parse($this->data['fchaIngresoDesde']));
		if(isset($this->data['fchaIngresoHasta']))
			$query->whereDate('CONT_FECHAINGRESO', '<=', Carbon::parse($this->data['fchaIngresoHasta']));
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
			$query->where('CONTRATOS.GRUP_ID', '=', $this->data['grupo']);
		if(isset($this->data['turno']))
			$query->where('CONTRATOS.TURN_ID', '=', $this->data['turno']);
		if(isset($this->data['estadorestriccion']))
			$query->where('CASOSMEDICOS.ESRE_ID', '=', $this->data['estadorestriccion']);
		if(isset($this->data['diagnostico']))
			$query->where('CASOSMEDICOS.DIGE_ID', '=', $this->data['diagnostico']);
		if(isset($this->data['prospecto']))
			$query->where('PROSPECTOS.PROS_CEDULA', '=', $this->data['prospecto']);

		return $this->buildJson($query);
	}

	/**
	 * 
	 *
	 * @return Json
	 */
	public function historicoRm()
	{
		$query = $this->getQueryRm()
			->whereIn('ESTADOSCONTRATOS.ESCO_ID', [EstadoContrato::ACTIVO, EstadoContrato::VACACIONES,EstadoContrato::RETIRADO]);

		if(isset($this->data['fchaIngresoDesde']))
			$query->whereDate('CONT_FECHAINGRESO', '>=', Carbon::parse($this->data['fchaIngresoDesde']));
		if(isset($this->data['fchaIngresoHasta']))
			$query->whereDate('CONT_FECHAINGRESO', '<=', Carbon::parse($this->data['fchaIngresoHasta']));
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
			$query->where('CONTRATOS.GRUP_ID', '=', $this->data['grupo']);
		if(isset($this->data['turno']))
			$query->where('CONTRATOS.TURN_ID', '=', $this->data['turno']);
		if(isset($this->data['estadorestriccion']))
			$query->where('CASOSMEDICOS.ESRE_ID', '=', $this->data['estadorestriccion']);
		if(isset($this->data['estadocontrato']))
			$query->where('CONTRATOS.ESCO_ID', '=', $this->data['estadocontrato']);
		if(isset($this->data['prospecto']))
			$query->where('PROSPECTOS.PROS_CEDULA', '=', $this->data['prospecto']);

		return $this->buildJson($query);
	}

	/**
	 * 
	 *
	 * @return Json
	 */
	public function novedadesRm()
	{
		$query = $this->getQueryNovedadesRm()
			->whereIn('ESTADOSCONTRATOS.ESCO_ID', [EstadoContrato::ACTIVO, EstadoContrato::VACACIONES,EstadoContrato::RETIRADO]);

		if(isset($this->data['fchaIngresoDesde']))
			$query->whereDate('CONT_FECHAINGRESO', '>=', Carbon::parse($this->data['fchaIngresoDesde']));
		if(isset($this->data['fchaIngresoHasta']))
			$query->whereDate('CONT_FECHAINGRESO', '<=', Carbon::parse($this->data['fchaIngresoHasta']));
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
			$query->where('CONTRATOS.GRUP_ID', '=', $this->data['grupo']);
		if(isset($this->data['turno']))
			$query->where('CONTRATOS.TURN_ID', '=', $this->data['turno']);
		if(isset($this->data['estadorestriccion']))
			$query->where('CASOSMEDICOS.ESRE_ID', '=', $this->data['estadorestriccion']);
		if(isset($this->data['prospecto']))
			$query->where('PROSPECTOS.PROS_CEDULA', '=', $this->data['prospecto']);

		return $this->buildJson($query);
	}

	/**
	 * 
	 *
	 * @return Json
	 */
	public function atributosPorEmpleado()
	{
		$query = $this->getQueryAtributos()
			->whereIn('ESTADOSCONTRATOS.ESCO_ID', [EstadoContrato::ACTIVO, EstadoContrato::VACACIONES,EstadoContrato::RETIRADO]);

		if(isset($this->data['fchaIngresoDesde']))
			$query->whereDate('CONT_FECHAINGRESO', '>=', Carbon::parse($this->data['fchaIngresoDesde']));
		if(isset($this->data['fchaIngresoHasta']))
			$query->whereDate('CONT_FECHAINGRESO', '<=', Carbon::parse($this->data['fchaIngresoHasta']));
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
			$query->where('CONTRATOS.GRUP_ID', '=', $this->data['grupo']);
		if(isset($this->data['turno']))
			$query->where('CONTRATOS.TURN_ID', '=', $this->data['turno']);
		if(isset($this->data['atributo']))
			$query->where('ATRIBUTOS.ATRI_ID', '=', $this->data['atributo']);
		if(isset($this->data['prospecto']))
			$query->where('PROSPECTOS.PROS_CEDULA', '=', $this->data['prospecto']);

		return $this->buildJson($query);
	}

	/**
	 * 
	 *
	 * @return Json
	 */
	public function activosPlantillaNovedades()
	{
		$query = $this->getQueryActivosPlantilla()
			->whereIn('ESTADOSCONTRATOS.ESCO_ID', [EstadoContrato::ACTIVO, EstadoContrato::VACACIONES]);

		if(isset($this->data['fchaIngresoDesde']))
			$query->whereDate('CONT_FECHAINGRESO', '>=', Carbon::parse($this->data['fchaIngresoDesde']));
		if(isset($this->data['fchaIngresoHasta']))
			$query->whereDate('CONT_FECHAINGRESO', '<=', Carbon::parse($this->data['fchaIngresoHasta']));
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
			$query->where('CONTRATOS.GRUP_ID', '=', $this->data['grupo']);
		if(isset($this->data['turno']))
			$query->where('CONTRATOS.TURN_ID', '=', $this->data['turno']);
		if(isset($this->data['atributo']))
			$query->where('ATRIBUTOS.ATRI_ID', '=', $this->data['atributo']);
		if(isset($this->data['prospecto']))
			$query->where('PROSPECTOS.PROS_CEDULA', '=', $this->data['prospecto']);

		return $this->buildJson($query);
	}

	/**
	 * 
	 *
	 * @return Json
	 */
	public function listadoSeguridadSocial()
	{
		$query = $this->getQuerySeguridadSocial()
			->whereIn('ESTADOSCONTRATOS.ESCO_ID', [EstadoContrato::ACTIVO,EstadoContrato::RETIRADO,EstadoContrato::VACACIONES]);

		//dd($this->data);
		if(isset($this->data['fchaRetiroDesde']))
			$query->whereDate('CONT_FECHARETIRO', '>=', Carbon::parse($this->data['fchaRetiroDesde']));
		if(isset($this->data['fchaRetiroHasta']))
			$query->whereDate('CONT_FECHARETIRO', '<=', Carbon::parse($this->data['fchaRetiroHasta']));
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
		if(isset($this->data['grupo']))
			$query->where('CONTRATOS.GRUP_ID', '=', $this->data['grupo']);
		if(isset($this->data['turno']))
			$query->where('CONTRATOS.TURN_ID', '=', $this->data['turno']);
		if(isset($this->data['prospecto']))
			$query->where('PROSPECTOS.PROS_CEDULA', '=', $this->data['prospecto']);
		if(isset($this->data['negocio']))
			$query->where('CONTRATOS.NEGO_ID', '=', $this->data['negocio']);

		return $this->buildJson($query);
	}

}