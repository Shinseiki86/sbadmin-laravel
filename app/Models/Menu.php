<?php
namespace App\Models;

use App\Models\ModelWithSoftDeletes;

class Menu extends ModelWithSoftDeletes
{
	
	//Nombre de la tabla en la base de datos   
	protected $table = 'MENUS';
	protected $primaryKey =  'MENU_ID';

	//Traza: Nombre de campos en la tabla para auditoría de cambios
	const CREATED_AT = 'MENU_FECHACREADO';
	const UPDATED_AT = 'MENU_FECHAMODIFICADO';
	const DELETED_AT = 'MENU_FECHAELIMINADO';
	protected $dates = ['MENU_FECHACREADO','MENU_FECHAMODIFICADO','MENU_FECHAELIMINADO'];

	public $fillable = [
		'MENU_LABEL',
		'MENU_URL',
		'MENU_ICON',
		'MENU_PARENT',
		'MENU_ORDER',
		'MENU_POSITION',
		'MENU_ENABLED',
	];

	public static function rules(){
		$rules = [
			'MENU_LABEL'  => ['required', 'max:20', ],//'unique:MENUS,MENU_LABEL,'.$this->getKey().',MENU_ID'],
			'MENU_URL'    => ['max:300', ],//'unique:MENUS,MENU_URL,'.$this->getKey().',MENU_ID'],
			'MENU_ICON'   => ['string', 'max:300'],
		];
		return $rules;
	}

	public function getChildren($data, $line)
	{
		$children = [];
		foreach ($data as $line1) {
			if ($line['MENU_ID'] == $line1['MENU_PARENT']) {
				$children = array_merge($children, [ array_merge($line1, ['submenu' => $this->getChildren($data, $line1) ]) ]);
			}
		}
		return $children;
	}

	public function optionsMenu($showEnabled=false, $position='LEFT')
	{
		$arrMenu = $showEnabled ? $this : $this->where('MENU_ENABLED', true);

		return $arrMenu->where('MENU_POSITION', $position)
			->orderby('MENU_PARENT')
			->orderby('MENU_ORDER')
			->orderby('MENU_LABEL')
			->get()
			->toArray();
	}

	public static function menus($showEnabled=false, $position='LEFT')
	{
		$menus = new Menu();
		$data = $menus->optionsMenu($showEnabled, $position);

		$menuAll = [];
		foreach ($data as $line) {
			$item = [ array_merge($line, ['submenu' => $menus->getChildren($data, $line) ]) ];
			$menuAll = array_merge($menuAll, $item);
		}
		
		return $menus->menuAll = $menuAll;
	}
}
