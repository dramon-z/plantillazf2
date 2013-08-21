<?php

namespace Plantilla\DAO;

class UserRol extends Object\AbstractObject {
	
	protected $tableName = 'users_roles';
	protected $primaryKeyColumn = 'user_rol_id';

	/**
	 * pobla celular
	 * @param int $user_rol_id
	 * @param int $rol_id
	 * @param int $user_id
	 */
	public function poblar($user_rol_id,$rol_id,$user_id){
		$this->populate(array(
				'user_rol_id' => $user_rol_id,
				'rol_id' => $rol_id,
				'user_id' => $user_id,
		));
	}
	
}

?>