<?php

namespace Plantilla\Servicios;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PermisoServicio implements ServiceLocatorAwareInterface {
	protected $serviceLocator = null;	

	/**
	*obtiene los roles del usuario en sesion
	*@param $user_id
	*@return Plantilla\DAO\Rol
	*/
	public function getRolesByUserId($user_id){
		$rol = $this->getServiceLocator()->get('Plantilla\DAO\Rol');
		$rol->getByUserId($user_id);
		return $rol;
	}

	public function getServiceLocator(){
		return $this->serviceLocator;
	}

	public function setServiceLocator(ServiceLocatorInterface $serviceLocator) {
		$this->serviceLocator = $serviceLocator;		
		return $this;
	}

}