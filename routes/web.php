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
// Authentication Routes...
Auth::routes();
Route::get('password/email/{id}', 'Auth\ForgotPasswordController@sendEmail');
Route::get('password/reset/{id}', 'Auth\ForgotPasswordController@showResetForm');

Route::group(['prefix'=>'auth', 'as'=>'auth.', 'namespace'=>'Auth'], function() {
	Route::resource('usuarios', 'RegisterController');
	Route::resource('roles', 'RoleController');
	Route::resource('permisos', 'PermissionController');
});

//Dashboard
Route::get('getDashboardUsuariosPorRol', 'Auth\RoleController@getUsuariosPorRol');


//Página principal. Si el usuario es admin, se muestra el dashboard.
Route::group(['middleware'=>'auth'], function() {
	Route::get('/', function(){
		if(Entrust::hasRole(['owner','admin','gesthum']))
			return view('dashboard/charts');
		return view('layouts.menu');
	});
	Route::get('getArrModel', 'Controller@ajax');
});

Route::group(['prefix'=>'app', 'as'=>'app.', 'namespace'=>'App'], function() {
	Route::resource('menu', 'MenuController', ['parameters'=>['menu'=>'MENU_ID']]);
	Route::resource('parametersglobal', 'ParameterGlobalController', ['parameters'=>['parametersglobal'=>'PGLO__ID']]);
	Route::post('menu/reorder', 'MenuController@reorder')->name('menu.reorder');
	Route::get('upload', 'UploadDataController@index')->name('upload.index');
	Route::post('upload', 'UploadDataController@upload')->name('upload');

	Route::get('createFromAjax/{model}', 'ModelController@createFromAjax')->name('createFromAjax');
});

Route::group(['prefix'=>'reports', 'as'=>'reports.', 'namespace'=>'Report'], function() {
	Route::get('/', 'ReportController@index');
	Route::get('/viewForm', 'ReportController@viewForm');
	
	Route::post('getData/{controller}/{action}', 'ReportController@getData');
});

/*************  Fin Routes del sistema  *************/


Route::group(['prefix'=>'cnfg-geograficos', 'as'=>'CnfgGeograficos.', 'namespace'=>'CnfgGeograficos'], function() {
	Route::resource('paises', 'PaisController', ['parameters'=>['pais'=>'PAIS_ID']]);
	Route::get('getPaises', 'PaisController@getData');
	Route::resource('departamentos', 'DepartamentoController', ['parameters'=>['departamento'=>'DEPA_ID']]);
	Route::get('getDepartamentos', 'DepartamentoController@getData');
	Route::resource('ciudades', 'CiudadController', ['parameters'=>['ciudad'=>'CIUD_ID']]);
	Route::get('getCiudades', 'CiudadController@getData');
	Route::resource('barrios', 'BarrioController', ['parameters'=>['barrio'=>'BARR_ID']]);
	Route::get('getBarrios', 'BarrioController@getData');
});


