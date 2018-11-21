<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*************  Routes del sistema  *************/
//Autenticación
Auth::routes();
Route::group(['prefix'=>'auth', 'as'=>'Auth.', 'namespace'=>'Auth'], function() {
	Route::resource('usuarios', 'RegisterController');
	Route::resource('roles', 'RoleController');
	Route::resource('permisos', 'PermissionController');
});

Route::get('password/email/{id}', 'Auth\ForgotPasswordController@sendEmail');
Route::get('password/reset/{id}', 'Auth\ForgotPasswordController@showResetForm');

Route::group(['middleware'=>'auth'], function() {
	Route::get('/', function(){
		if(Entrust::hasRole(['owner','admin','gesthum']))
			return view('dashboard/charts');
		return view('layouts.menu');
	});
	Route::get('getArrModel', 'Controller@ajax');
});

Route::group(['prefix'=>'app', 'as'=>'App.', 'namespace'=>'App'], function() {
	Route::resource('menu', 'MenuController', ['parameters'=>['menu'=>'MENU_ID']]);
	Route::post('menu/reorder', 'MenuController@reorder')->name('menu.reorder');
	Route::get('parameters', 'ParametersController@index')->name('parameters');
	Route::get('upload', 'UploadDataController@index')->name('upload.index');
	Route::post('upload', 'UploadDataController@upload')->name('upload');
	Route::resource('parametrosgenerales', 'ParametroGeneralController');

	Route::get('createFromAjax/{model}', 'ModelController@createFromAjax')->name('createFromAjax');
});

/*************  Fin Routes del sistema  *************/


Route::group(['prefix'=>'cnfg-geograficos', 'as'=>'CnfgGeograficos.', 'namespace'=>'CnfgGeograficos'], function() {
	Route::resource('paises', 'PaisController', ['parameters'=>['pais'=>'PAIS_ID']]);
	Route::get('getPaises', 'PaisController@getData');
	Route::resource('departamentos', 'DepartamentoController', ['parameters'=>['departamento'=>'DEPA_ID']]);
	Route::get('getDepartamentos', 'DepartamentoController@getData');
	Route::resource('ciudades', 'CiudadController', ['parameters'=>['ciudad'=>'CIUD_ID']]);
	Route::get('getCiudades', 'CiudadController@getData');
});




Route::group(['prefix'=>'reportes', 'as'=>'Reportes.', 'namespace'=>'Reportes', 'middleware'=>'auth'], function() {
	Route::get('/', 'ReporteController@index');
	Route::get('/viewForm', 'ReporteController@viewForm');
	

	Route::post('getData/{reporte}', 'ReporteController@getData');

	//Route::post('LogsAuditorias', 'RptAuditoriasController@logsAuditoria');
});