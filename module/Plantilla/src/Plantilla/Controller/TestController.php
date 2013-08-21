<?php

namespace Plantilla\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Plantilla\Form;
use Zend\Session\Container;



class TestController extends AbstractActionController {
    const ROUTE_LOGIN        = 'zfcuser/login';
    /**
     * (non-PHPdoc)Evento
     * @see \Zend\Mvc\Controller\AbstractActionController::onDispatch()
     */
    public function onDispatch( \Zend\Mvc\MvcEvent $e )
    {
    	if (!$this->zfcUserAuthentication()->hasIdentity()) {
    		return $this->redirect()->toRoute(static::ROUTE_LOGIN);
    	}
    	$user = $this->zfcUserAuthentication()->getIdentity();
    	$permisoServicio = $this->getServiceLocator()->get('Plantilla\Servicios\PermisoServicio');
    	$roles=$permisoServicio->getRolesByUserId($user->getId());
    	$action=$e -> getRouteMatch() -> getParams();    	   
    	$route = $e -> getRouteMatch() -> getMatchedRouteName().'/'.$action['action'];
    	$permit=false;
    	while($roles->next()){
    		if($e -> getViewModel() -> acl -> isAllowed($roles->nombre->getValue(), $route)){
    			$permit =true;
    			break;
    		}
       	}
		if(!$permit){
    		$response = $e -> getResponse();
			$response -> getHeaders() -> addHeaderLine('Location', $e -> getRequest() -> getBaseUrl() . '/404');
		    $response -> setStatusCode(303);
    	   }
    	return parent::onDispatch( $e );
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
	/**
	*repsuesta json
	*
	*/
	public function acltest2Action(){
		$request = $this->getRequest ();
		$params = $request->getPost();
		$params = $this->params()->fromPost();
		return new JsonModel(array('success'=>true,'object'=>$params,));
	}
}