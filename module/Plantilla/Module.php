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
		
	}

	public function getConfig()
	{
		return include __DIR__ . '/config/module.config.php';
	}
	public function getAutoloaderConfig()
	{
		return array(
				'Zend\Loader\StandardAutoloader' => array(
						'namespaces' => array(
								__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
						),
				),
		);
	}
}
