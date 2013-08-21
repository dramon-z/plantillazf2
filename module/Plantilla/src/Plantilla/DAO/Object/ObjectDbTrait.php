<?php

namespace Plantilla\DAO\Object;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\RowGateway\RowGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Metadata\Metadata;

trait ObjectDbTrait {
	
	
	use \Plantilla\Object\Db\ObjectMetadataTrait;
	
	/**
	 *
	 * @var Zend\Db\Adapter\Adapter
	 */
	protected $adapter = null;
	/**
	 *
	 * @var String Table Name
	 */
	protected $tableName = null;
	/**
	 *
	 * @var String llave primaria de la tabla
	 */
	protected $primaryKeyColumn = null;
	/**
	 *
	 * @var Zend\Db\TableGateway\TableGateway
	 */
	protected $tableGateway = null;
	/**
	 *
	 * @var Zend\Db\RowGateway
	 */
	protected $rowGateway = null;
	
	
	
	protected function initializedObjectDb() {
		if (!$this->isInitialized) {
	
			if ($this->adapter && $this->tableName && $this->primaryKeyColumn){
				echo "Inicializando ObjectDbTrait";
				$this->rowGateway = new RowGateway ( $this->primaryKeyColumn, $this->tableName, $this->adapter );
				$this->tableGateway = new TableGateway ( $this->tableName, $this->adapter );
			}
			else{
				throw new \Exception(sprintf('Especifique los siguientes atributos [adapter, tableName, primaryKeyColumn], para poder utilizar el metodo "%s" in %s', 'initializedObjectDb', get_class($this)));
			}
		}
	}
	
	
	public function getRowGateway(){
		$this->initialize();
		
		return $this->rowGateway;
		
	}
	
	public function getTableGateway(){
		$this->initialize();
		
		return $this->tableGateway;
	}
	
}

