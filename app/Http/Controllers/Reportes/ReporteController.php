<?php
namespace App\Http\Controllers\Reportes;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Report;
use App\Models\Role;

class ReporteController extends Controller
{
	protected $data = null;

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
		$roles = \Entrust::user()->roles;
		$arrReportes = Report::join('report_role', 'report_role.report_id','reports.id')
						->where('enable',true)
						->whereIn('report_role.role_id',$roles->pluck('id'))
						->select([
							'*',
							expression_concat(['code','name'], 'display', ' - '),
							expression_concat(['controller','action'], 'route', '_')
						])->get()->toArray();
		return view('reportes.index', compact('arrReportes'));
	}

	/**
	 * Retorna el html del formulario requerido, el cual es renderizado por JQuery.
	 * @param  Request $request
	 * @return json
	 */
	public function viewForm(Request $request)
	{
		$form = $request->input('form');
		return response()->json(view('reportes.formRep'.$form)->render());
	}


	/**
	 * Dependiento la url, crea una instancia del controlador y ejecuta el query requerido, retornando un json.
	 * @param  string $controller
	 * @param  string $action
	 * @return json
	 */
	public function getData($controller, $action)
	{
		$controller = '\App\Http\Controllers\Reportes\Rpt'.$controller.'Controller';
		$controler = new $controller;
		return app($controller)->$action();
	}


	/**
	 * Retorna el json con el query contruido.
	 * @param  QueryBuilder $query
	 * @param  string $columnChart Columna por defecto al renderizar el gráfico
	 * @return json
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


}
