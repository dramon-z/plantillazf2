<?php

namespace Plantilla\DAO;

class Permiso extends Object\AbstractObject {
	
	protected $tableName = 'permisos';
	protected $primaryKeyColumn = 'permiso_id';

	/**
	 * pobla celular
	 * @param int $permiso_id
	 * @param string $url
	 * @param string $descripcion
	 */
	public function poblar($permiso_id,$url,$descripcion){
		$this->populate(array(
				'permiso_id' => $permiso_id,
				'url' => $url,
				'descripcion'=>$descripcion
		));
	}	
}

?>