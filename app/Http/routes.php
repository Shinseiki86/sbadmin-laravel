<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

//Autenticación
Route::auth();
Route::group(['prefix' => 'auth', 'namespace' => 'Auth', 'middleware' => ['auth', 'role:admin']], function() {
	Route::resource('usuarios', 'AuthController');
	Route::resource('roles', 'RoleController');
	Route::resource('permisos', 'PermissionController');
	Route::resource('menu', 'MenuController', ['parameters'=>['menu' => 'MENU_ID']]);
	Route::post('menu/reorder', 'MenuController@reorder')->name('auth.menu.reorder');
});
Route::get('password/email/{USER_id}', 'Auth\PasswordController@sendEmail');
Route::get('password/reset/{USER_id}', 'Auth\PasswordController@showResetForm');

Route::group(['prefix' => 'app', 'middleware' => ['auth', 'role:admin']], function() {
	Route::get('parameters', 'ParametersController@index')->name('app.parameters');
});

Route::group(['middleware' => 'auth'], function() {
	Route::get('/',  function(){return view('dashboard/index');});
});

Route::group(['prefix' => 'cnfg-geograficos', 'namespace' => 'CnfgGeograficos'], function() {
	Route::resource('paises', 'PaisController', ['parameters'=>['pais' => 'PAIS_ID']]);
	Route::get('getPaises', 'PaisController@getData');
	Route::resource('departamentos', 'DepartamentoController', ['parameters'=>['departamento' => 'DEPA_ID']]);
	Route::get('getDepartamentos', 'DepartamentoController@getData');
	Route::resource('ciudades', 'CiudadController', ['parameters'=>['ciudad' => 'CIUD_ID']]);
	Route::get('getCiudades', 'CiudadController@getData');
});

