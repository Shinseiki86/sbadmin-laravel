<?php
namespace App\Models;

use Zizaco\Entrust\EntrustRole;
use App\Traits\ModelRulesTrait;
//use App\Traits\SoftDeletesTrait;
use App\Traits\RelationshipsTrait;

class Role extends EntrustRole
{
    use RelationshipsTrait, ModelRulesTrait;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'display_name',
		'description',
	];

	public static function rules($id = 0){
		return [
			'name' => 'required|max:15|'.static::unique($id,'name'),
			'display_name' => 'required|max:50|'.static::unique($id,'display_name'),
			'description'  => ['required','max:100'],
		];
	}

	//establecemos las relacion de muchos a muchos con el modelo User, ya que un rol 
	//lo pueden tener varios usuarios y un usuario puede tener varios roles
	public function users(){
		return $this->belongsToMany(User::class);
	}

	//establecemos las relaciones con el modelo Permission, ya que un permiso puede tener varios roles
	//y un rol lo pueden tener varios permisos
	public function permissions(){
		return $this->belongsToMany(Permission::class);
	}

}