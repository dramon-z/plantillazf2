<?php

namespace Plantilla\DAO;

class User extends Object\AbstractObject {
	
	protected $tableName = 'user';
	protected $primaryKeyColumn = 'user_id';

	/**
	 * pobla celular
	 * @param int $user_id
	 * @param string $username
	 * @param string $email
	 * @param string $display_name
	 * @param string $password
	 * @param string $state
	 */
	public function poblar($user_id,$username,$email,$display_name,$password,$state){
		$this->populate(array(
				'user_id' => $user_id,
				'username' => $username,
				'email' => $email,
				'display_name'=>$display_name,
				'password'=>$password,
				'state'=>$state,
		));
	}

	/**
	*obtiene los permiso del rol
	*@return Plantilla\DAO\PermisoRol
	*/
	public function getRoles(){
		$rol = $this->getServiceLocator()->get('Plantilla\DAO\Rol');
		$rol->getByUserId($this->userId->getValue());
		return $rol;
	}
	
}

?>