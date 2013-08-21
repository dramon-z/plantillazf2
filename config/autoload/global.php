<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
    'service_manager' => array(
	    	'invokables' => array(
	            'Zend\Session\SessionManager' => 'Zend\Session\SessionManager',
	        ),
			'factories' => array(
					'Zend\Db\Adapter\Adapter'
					=> 'Zend\Db\Adapter\AdapterServiceFactory',
                    'Navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
			),
	),
	'db' => array(
			'driver' => 'mysqli',
			'dsn'=> 'mysql:dbname=plantilla;host=localhost',
			'schema'	=> 'plantilla',
			'host'=>'192.168.1.67',
			'driver_options' => array(
					PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
			),
			'options' => array('buffer_results' => true),
	),

	'di' => array(),
);
