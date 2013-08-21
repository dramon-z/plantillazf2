<?php

namespace Plantilla\DAO\Object;

class ColumnObject {
	
	protected $adapter;
	protected $scheme;
	protected $table;
	protected $value;
	protected $name;
	
	protected $setFunction;
	protected $getFunction;
	
	
	
	public function __construct($metadataColumn = null){
		if ($metadataColumn instanceof \Zend\Db\Metadata\Object\ColumnObject){
			$this->setName($metadataColumn->getName());
		}
		elseif (is_string($metadataColumn)){
			$this->setName($metadataColumn);
		}
		
	}
	
	
	function __toString(){
		return ''.$this->value;
	}
	
	/**
	 * @return the $value
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * @return the $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return the $setFunction
	 */
	public function getSetFunction() {
		return $this->setFunction;
	}

	/**
	 * @return the $getFunction
	 */
	public function getGetFunction() {
		return $this->getFunction;
	}

	/**
	 * @param field_type $value
	 */
	public function setValue($value) {
		$this->value = $value;
	}

	/**
	 * @param field_type $name
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @param field_type $setFunction
	 */
	public function setSetFunction($setFunction) {
		$this->setFunction = $setFunction;
	}

	/**
	 * @param field_type $getFunction
	 */
	public function setGetFunction($getFunction) {
		$this->getFunction = $getFunction;
	}

	
}
