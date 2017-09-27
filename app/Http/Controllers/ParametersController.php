<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class ParametersController extends Controller
{
	protected $route = 'admin';

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Muestra una lista de los registros.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view($this->route.'.parameters');
	}

	/**
	 * Retorna .
	 *
	 * @return json
	 */
	public function changeParameter()
	{
		$data = $request->all();
		return json_encode($data);
	}

}

