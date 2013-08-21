<?php
namespace Plantilla;
date_default_timezone_set('Mexico/General');
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Session\Container;

class Module
{
	public function onBootstrap(MvcEvent $e)
	{
		$sm = $e->getApplication()->getServiceManager();
		$sm->get('translator');
		$this -> initAcl($e);
	}

	public function getConfig()
	{
		return include __DIR__ . '/config/module.config.php';
	}
	public function getAutoloaderConfig()
	{
		return array(
				'Zend\Loader\ClassMapAutoloader' => array(
	                __DIR__ . '/autoload_classmap.php',
	            ),
				'Zend\Loader\StandardAutoloader' => array(
						'namespaces' => array(
								__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
						),
				),
		);
	}
	public function initAcl(MvcEvent $e) { 
	    $acl = new \Zend\Permissions\Acl\Acl();
	    $sm = $e->getApplication()->getServiceManager();
	    $rolesDb=$sm->create('Plantilla\DAO\Rol');
	    $rolesDb->listAll();
	    $roles = include __DIR__ . '/config/acl.role.php';
	    $allResources = array();
	    while($rolesDb->next()){
	    	$role=$rolesDb->nombre->getValue();
	    	$role = new \Zend\Permissions\Acl\Role\GenericRole($role);
		    $acl -> addRole($role);
		    $permisoRol=$rolesDb->getPermisoRol();
		    while($permisoRol->next()){
		    	$permiso=$permisoRol->getPermiso();
		    	array_push($allResources,$permiso->url->getValue());
		    	if($acl -> hasResource($permiso->url->getValue()))continue;
		            $acl -> addResource(new \Zend\Permissions\Acl\Resource\GenericResource($permiso->url->getValue()));
		    }
		    foreach ($allResources as $resource) {
		        $acl -> allow($role, $resource);
		    }
		    unset($allResources);
		    $allResources=array();	
	    }
	    $e -> getViewModel() -> acl = $acl; 
	}
}
