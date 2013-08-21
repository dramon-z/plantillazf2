<?php

namespace Plantilla\DAO;

class Rol extends Object\AbstractObject {
	
	protected $tableName = 'roles';
	protected $primaryKeyColumn = 'rol_id';

	/**
	 * pobla celular
	 * @param int $rol_id
	 * @param string $nombre
	 * @param string $descripcion
	 */
	public function poblar($rol_id,$nombre,$descripcion){
		$this->populate(array(
				'rol_id' => $rol_id,
				'nombre' => $nombre,
				'descripcion' => $descripcion,
		));
	}

	/**
	*obtiene los permiso del rol
	*@return Plantilla\DAO\PermisoRol
	*/
	public function getPermisoRol(){
		$permisoRol = $this->getServiceLocator()->create('Plantilla\DAO\PermisoRol');
		$permisoRol->getByRolId($this->rolId->getValue());
		return $permisoRol;
	}
	/**
	*obtine los roles atravez del user id
	*@param $user_id
	*@return count;
	*/
	public function getByUserId($user_id){
		$sql="SELECT * FROM roles
				LEFT JOIN users_roles using(rol_id)
				WHERE user_id=".$user_id;
		$this->loadByQuery($sql);
		return $this->count();
	}
	
}

?>