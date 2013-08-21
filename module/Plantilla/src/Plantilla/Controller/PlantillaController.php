<?php

namespace Plantilla\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Session\Container;
use Zend\Http\Client as Zend_Http_Client;

class PlantillaController extends AbstractActionController {
	
	const ROUTE_LOGIN        			  = 'zfcuser/login';
	
	public function onDispatch( \Zend\Mvc\MvcEvent $e )
		{

		if (!$this->zfcUserAuthentication()->hasIdentity()) {
				return $this->redirect()->toRoute(static::ROUTE_LOGIN);
		}				
		return parent::onDispatch( $e );
	}

	/**
	 * indice principal de Plantilla
	 * @return \Zend\View\Model\ViewModel
	 */
	public function indexAction() {	
			$view = new ViewModel(	);
		return $view;
	}
	/**
	*repsuesta json
	*
	*/
	public function acltestAction(){
		$request = $this->getRequest ();
		$params = $request->getPost();
		$params = $this->params()->fromPost();
		return new JsonModel(array('success'=>true,'object'=>$params,));
	}
	
	
} 