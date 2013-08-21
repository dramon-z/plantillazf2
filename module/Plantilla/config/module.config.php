<?php
return array (
		'controllers' => array (
				'invokables' => array (
						'Plantilla\Controller\Plantilla' => 'Plantilla\Controller\PlantillaController',
						'Plantilla\Controller\Test' => 'Plantilla\Controller\TestController'
				) 
		),
		'router' => array (
				'routes' => array (
						'home' => array(
								'type' => 'Zend\Mvc\Router\Http\Literal',
								'options' => array(
										'route'    => '/',
										'defaults' => array(
												'controller' => 'Plantilla\Controller\Plantilla',
												'action'     => 'index',
										),
								),
						),
					'plantilla' => array (
								'type' => 'Segment',
								'options' => array (
										'route' => '/plantilla[/:action]',
										'constraints' => array (
												'action' => '[a-zA-Z][a-zA-Z0-9_-]*' 
										),
										'defaults' => array (
												'__NAMESPACE__' => 'Plantilla\Controller',
												'controller'    => 'Plantilla',
												'action'        => 'index',
										) 
								),
								'may_terminate' => true,
							'child_routes' => array (
										'wildcard' => array (
												'type' => 'Wildcard' 
										) 
								) 
						),
					'test' => array (
								'type' => 'Segment',
								'options' => array (
										'route' => '/test[/:action]',
										'constraints' => array (
												'action' => '[a-zA-Z][a-zA-Z0-9_-]*' 
										),
										'defaults' => array (
												'controller' => 'Plantilla\Controller\Test',
												'action' => 'index' 
										) 
								),
								'may_terminate' => true,
								'child_routes' => array (
										'wildcard' => array (
												'type' => 'Wildcard' 
										) 
								) 
						),
				)
				 
		),
		'service_manager' => array (
				'factories' => array (
						'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
						'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory', 
						'Navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory'
				) 
		),
		'translator' => array (
				'locale' => 'es_ES',
				'translation_file_patterns' => array (
						array (
								'type' => 'gettext',
								'base_dir' => __DIR__ . '/../language',
								'pattern' => '%s.mo' 
						) 
				) 
		),
		'view_manager' => array (
				'display_not_found_reason' => true,
				'display_exceptions' => true,
				'doctype' => 'HTML5',
				'not_found_template' => 'error/404',
				'exception_template' => 'error/index',
				'template_map' => array (
						'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
						'layout/ajax'=>__DIR__ .'/../view/layout/layout-ajax.phtml',
						'layout/place'=>__DIR__ .'/../view/layout/layout-place.phtml',
						'plantilla/plantilla/index' => __DIR__ . '/../view/plantilla/plantilla/index.phtml',
						'error/index' => __DIR__ . '/../view/error/index.phtml',
				),
				'template_path_stack' => array (
						
						__DIR__ . '/../view' 
				),
				'strategies' => array (
						'ViewJsonStrategy' 
				) 
		) 
);