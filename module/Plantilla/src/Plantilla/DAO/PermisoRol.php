<?php

namespace Plantilla\DAO;

class PermisoRol extends Object\AbstractObject {
	
	protected $tableName = 'permisos_roles';
	protected $primaryKeyColumn = 'permiso_rol_id';

	/**
	 * pobla celular
	 * @param int $permiso_rol_id
	 * @param string $permiso_id
	 * @param int $rol_id
	 */
	public function poblar($permiso_rol_id,$permiso_id,$rol_id){
		$this->populate(array(
				'permiso_rol_id' => $permiso_rol_id,
				'permiso_id' => $permiso_id,
				'rol_id'=>$rol_id
		));
	}
	/**
	*obtiene permiso roles mediante el rol_id
	*@param rol_id
	*@return count;
	*/
	public function getByRolId($rol_id){
		$sql="SELECT * FROM permisos_roles WHERE rol_id=".$rol_id;
		$this->loadByQuery($sql);
		return $this->count();
	}
	/**
	*obtiene el permiso
	*@return Plantilla\DAO\Permiso
	*/
	public function getPermiso(){
		$permiso = $this->getServiceLocator()->get('Plantilla\DAO\Permiso');
		$permiso->loadById($this->permisoId->getValue());
		return $permiso;
	}
	
}

?>