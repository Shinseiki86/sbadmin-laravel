<?php
namespace App\Http\Controllers\Reportes;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Prospecto;
use App\Models\User;

class ReporteController extends Controller
{
	protected $data = null;

	private $reportessst = [

		/*Bloque para reportes de SST*/
		//==============================================================================================
		['id'=>'ContratosHeadcountRm', 'title'=>'209 - HEADCOUNT DE R.M'],
		['id'=>'ContratosHistoricoRm', 'title'=>'210 - HISTÓRICO DE R.M'],
		['id'=>'ContratosNovedadesRm', 'title'=>'211 - NOVEDADES DE SEGUIMIENTO A R.M'],

		['id'=>'AusentismosListadoAusentismosOperaciones', 'title'=>'500 - LISTADO DE AUSENTISMOS INICIALES - OPERACIONES'],
		['id'=>'AusentismosListadoAusentismosProrrogasOperaciones', 'title'=>'501 - LISTADO DE AUSENTISMOS PROROGAS - OPERACIONES'],
		//==============================================================================================

	];

	private $reportescompartidos = [

		/*Bloque para reportes de Turnos y Novedades*/
		//==============================================================================================
		['id'=>'AsistenciasEmpleados', 'title'=>'600 - LISTADO DE ASISTENCIAS POR EMPLEADO', 'filterRequired' => false],
		//==============================================================================================

		/*Bloque para reportes de Personal*/
		//==============================================================================================
		['id'=>'ContratosOperaciones', 'title'=>'700 - LISTADO GENERAL DE PERSONAL'],
		//==============================================================================================

		/*Bloque para reportes informativos*/
		//==============================================================================================
		['id'=>'AusentismosListadoConceptosAusencias', 'title'=>'702 - CONCEPTOS DE AUSENCIAS'],
		//==============================================================================================

	];

	private $reportesgh = [

		/*Bloque para reportes de Prospectos*/
		//==============================================================================================
		['id'=>'ProspectosSinContrato', 'title'=>'100 - HOJAS DE VIDA BÁSICAS'],
		['id'=>'ProspectosDescartados', 'title'=>'101 - HOJAS DE VIDA DESCARTADAS'],
		['id'=>'ProspectosCumpleanios', 'title'=>'102 - LISTADO DE CUMPLEAÑOS', 'filterRequired' => true],
		//==============================================================================================

		/*Bloque para reportes de Contratos*/
		//==============================================================================================
		['id'=>'ContratosActivos', 'title'=>'200 - CONTRATOS ACTIVOS (HEADCOUNT)'],
		['id'=>'ContratosHistorico', 'title'=>'201 - HISTÓRICO DE CONTRATOS'],
		['id'=>'ContratosIngresosPorFecha', 'title'=>'202 - INGRESOS POR FECHA', 'filterRequired' => true],
		['id'=>'ContratosRetirosPorFecha', 'title'=>'203 - RETIROS POR FECHA', 'filterRequired' => true],
		['id'=>'ContratosHistoriaPorCedula', 'title'=>'204 - HISTORIA LABORAL POR CÉDULA', 'filterRequired' => true],
		['id'=>'ContratosActivosPorPeriodo', 'title'=>'205 - ACTIVOS POR PERIODO', 'filterRequired' => true],
		['id'=>'ContratosProximosTemporalidad', 'title'=>'206 - CONTRATOS PRÓXIMOS A VENCIMIENTO (EST)'],
		['id'=>'ContratosProximosFinalizar', 'title'=>'207 - CONTRATOS PRÓXIMOS A FINALIZAR', 'filterRequired' => true],
		['id'=>'ContratosActivosPlantillaNovedades', 'title'=>'208 - ACTIVOS PLANTILLA DE NOVEDADES'],
		['id'=>'ContratosHeadcountRm', 'title'=>'209 - HEADCOUNT DE R.M'],
		['id'=>'ContratosHistoricoRm', 'title'=>'210 - HISTÓRICO DE R.M'],
		['id'=>'ContratosNovedadesRm', 'title'=>'211 - NOVEDADES DE SEGUIMIENTO A R.M'],
		
		['id'=>'ContratosAtributosPorEmpleado', 'title'=>'212 - ATRIBUTOS POR EMPLEADO', 'filterRequired' => true],
		['id'=>'ContratosListadoSeguridadSocial', 'title'=>'213 - LISTADO PARA SEGURIDAD SOCIAL', 'filterRequired' => true],
		//==============================================================================================

		/*Bloque para reportes de Plantas*/
		//==============================================================================================
		['id'=>'PlantasAutorizadas', 'title'=>'300 - PLANTAS DE PERSONAL AUTORIZADAS'],
		['id'=>'PlantasMovimientos', 'title'=>'301 - MOVIMIENTOS DE PLANTAS DE PERSONAL'],
		['id'=>'PlantasVrsActivos', 'title'=>'302 - PLANTAS Vs. ACTIVOS'],
		//==============================================================================================

		/*Bloque para reportes de Tickets*/
		//==============================================================================================
		['id'=>'ticketsPorFecha', 'title'=>'400 - LISTADO DE TICKETS', 'columnChart'=>'EMPRESA'],
		//==============================================================================================

		/*Bloque para reportes de Ausentismos*/
		//==============================================================================================
		['id'=>'AusentismosListadoAusentismos', 'title'=>'500 - LISTADO DE AUSENTISMOS INICIALES'],
		['id'=>'AusentismosListadoAusentismosProrrogas', 'title'=>'501 - LISTADO DE AUSENTISMOS PROROGAS'],
		['id'=>'NovedadesEmpleados', 'title'=>'502 - LISTADO DE NOVEDADES DE NÓMINA', 'filterRequired' => false],
		//==============================================================================================

		/*Bloque para reportes de Indicadores*/
		//==============================================================================================
		['id'=>'ContratosIndicadorDeRotacion', 'title'=>'1000 - INDICADOR DE ROTACIÓN'],
		['id'=>'PlantasVrsActivosIndicador', 'title'=>'1001 - INDICADOR DE PLANTAS Vs ACTIVOS'],
		['id'=>'ContratosIndicadorDeRotacionTotal', 'title'=>'1002 - INDICADOR DE ROTACIÓN TOTAL'],
		//==============================================================================================

	];

	private $reportesop = [

		/*Bloque para reportes de Operaciones*/
		//==============================================================================================
		['id'=>'ContratosOperacionesSinClasificacion', 'title'=>'701 - PERSONAL SIN CLASIFICACIÓN'],
		['id'=>'MovimientosEmpleados', 'title'=>'702 - PROGRAMACIÓN DE TURNOS'],
		//==============================================================================================

		/*Bloque para reportes de Ausentismos*/
		//==============================================================================================
		['id'=>'AusentismosListadoAusentismosOperaciones', 'title'=>'500 - LISTADO DE AUSENTISMOS INICIALES - OPERACIONES'],
		['id'=>'AusentismosListadoAusentismosProrrogasOperaciones', 'title'=>'501 - LISTADO DE AUSENTISMOS PROROGAS - OPERACIONES'],
		//==============================================================================================
	];

	private $reportesadm = [

		/*Bloque para reportes de Administrador*/
		//==============================================================================================
		['id'=>'LogsAuditorias', 'title'=>'900 - LOGS DE AUDITORÍA'],
		//==============================================================================================
	];

	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('permission:reportes');
		//Datos recibidos desde la vista.
		$this->data = parent::getRequest();
	}

	/**
	 * Muestra una lista de los registros.
	 *
	 * @return Response
	 */
	public function index()
	{
		$arrReportes = $this->getReportArray(\Auth::user()->id);
		return view('reportes.index', compact('arrReportes'));
	}

	public function viewForm(Request $request)
	{
		$form = $request->input('form');

		return response()->json(view('reportes.formRep'.$form)->render());
	}

	public function getData($reporte)
	{
		dd($reporte);
	}


	/**
	 * 
	 *
	 * @return Response
	 */
	protected function buildJson($query, $columnChart = null)
	{
		$colletion = $query->get();
		$keys = $data = [];

		if(!$colletion->isEmpty()){
			$keys = array_keys($colletion->first()->toArray());
			$data = array_map(function ($arr){
					return array_flatten($arr);
				}, $colletion->toArray());
		}
		return response()->json(compact('keys', 'data', 'columnChart'));
	}

	/**
	 * 
	 *
	 * @return array
	 */
	public function getReportArray($id){
		$reports = null;
		$user = User::findOrFail($id);

		if($user->hasRole(['admin', 'gesthum', 'ejecutivo'])){
            //si es un administrador se listan todos los reportes del sistema
            $reports = array_merge($this->reportesgh, $this->reportescompartidos, $this->reportesop, $this->reportesadm);
        }elseif($user->hasRole(['superoper', 'cooroper'])) {
        	 //si es un usuario diferente de administrador se listan algunos de los reportes del sistema
            $reports = array_merge($this->reportesop, $this->reportescompartidos);
        }elseif($user->hasRole(['sst'])) {
        	 //si es un usuario de seguridad y salud en el trabajo solo muestra los reportes de su rol
            $reports = array_merge($this->reportessst, $this->reportescompartidos);
        }else{
        	$reports = array_merge($this->reportesop, $this->reportescompartidos);;
        }
        return $reports;
	}

}
