<?php

namespace Plantilla\DAO\Object;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\Adapter\Adapter;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\RowGateway\RowGateway;

abstract class AbstractObject 
	implements AdapterAwareInterface, ServiceLocatorAwareInterface, ObjectDbInterface 
	{
	public function getData(){
		return $this->data;
	}
		
	/**
	 * @var Adapter
	 */
	protected $adapter = null;
		
		
	/**
	 * @var ServiceLocatorInterface
	 */
	protected $serviceLocator = null;
	
	
	/**
	 *
	 * @var Zend\ServiceManager\ServiceManager
	 *
	 */
	protected $sm = null;
	
	/**
	 *
	 * @var Boolean Si la instancia ya fue inicializada
	 */
	protected $isInitialized = false;
	
	/**
	 *
	 * @var array() Arreglo de variables del objeto
	 */
	protected $vars = array ();
	/**
	 *
	 * @var Array() Arreglo de columnas de la tabla
	*/
	protected $columns = array ();
	/**
	 *
	 * @var Zend\Db\ResetSet\ResultSet
	*/
	private $resultSet = null;
	
	/**
	 * 
	 */
	private $data = null;
	
	
	/**
	 * Set service locator
	 *
	 * @param ServiceLocatorInterface $serviceLocator
	 * @return mixed
	 */
	public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
	{
		$this->serviceLocator = $serviceLocator;
	
		return $this;
	}
	
	/**
	 * Get service locator
	 *
	 * @return ServiceLocatorInterface
	 */
	public function getServiceLocator()
	{
		return $this->serviceLocator;
	}
	
	
	
	
	/**
	 * Set db adapter
	 *
	 * @param Adapter $adapter
	 * @return mixed
	 */
	public function setDbAdapter(Adapter $adapter)
	{
		$this->adapter = $adapter;
	
		return $this;
	}
	
	
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
				
				
				if (isset($this->schame)){
					$schame = $this->schame;
				}
				else {
					$schame = $this->adapter->getDriver()->getConnection()->getCurrentSchema();
				}
				
				
				
				$this->metadata = $this->getMetadata()->getTable($this->tableName, $schame);
				
				
				
				$columns = $this->metadata->getColumns();
				
				foreach($columns as $column){
					// echo '<br> Key: '. $column->getName();
					$columnObject = new ColumnObject($column);
					$this->vars[$column->getName()] = $columnObject;
					$this->columns[$column->getName()] = $columnObject;
					$this->{$this->camelize($column->getName())} = $columnObject;
				}
				
				
				$this->rowGateway = new RowGateway ( $this->primaryKeyColumn, $this->tableName, $this->adapter );
				$this->tableGateway = new TableGateway ( $this->tableName, $this->adapter );
				
			}
			else{
				throw new \Exception(sprintf('Especifique los siguientes atributos [adapter, tableName, primaryKeyColumn], para poder utilizar el metodo "%s" in %s', 'initializedObjectDb', get_class($this)));
			}
		}
	}
	
	
	/**
	 * Formatea un texto a formato de camello
	 * Utilizado para los nombres de las variables.
	 * Si pasas la variable prefijo.
	 * Eliminara el texto dentro de los nombres de las variables.
	 * @param String $name
	 * @param String $prefijo
	 * @return String $name_camelize
	 */
	public function camelize($name,$pre = '') {
		if ($name != '')
			$name = str_replace ( $pre, '', strtolower ( $name ) );
	
		$name = '_' . str_replace ( '_', ' ', strtolower ( $name ) );
		return ltrim ( str_replace ( ' ', '', ucwords ( $name ) ), '_' );
	}
	
	
	
	/**
	 * Convierte todas las variables del objeto a un arreglo.
	 *
	 * array('nombre_variableA' => 'valor_variableA');
	 *
	 * Puedes pasar un arreglo con variables Zion_vars y solo esas seran convertidas a un arreglo.
	 *
	 * @param unknown_type $vars
	 * @return array()
	 */
	public function toArray($vars = null) {
		$array = array ( );
	
		if ($vars === null)
			$vars = $this->vars;
	
			
		if (is_array($vars)){
			foreach ( $vars as $var ){
				$array [ $var->getName() ] = $var->getValue () ;
			}
		}
	
		return $array;
	}
	
	
	
	/**
	 * Alimenta las variables del objeto apartir de un arreglo();
	 * extFunt: funciones a disparar antes de asignar el valor
	 * separadar por comas.
	 *
	 * @param array() $array
	 * @param String $extFunt
	 */
	public function populate($array,$extFunt = '') {
		$this->initialize();
		
		$this->_formValues = array ( );
	
		foreach ( $this->vars as $var ) {
			if (isset ( $array [$var->getName()] )) {
// 				echo "<br> populate Columna: ". $var->getName() . " value: ". $array [$var->getName()];
	
				if (is_resource($array [$var->getName()])){
					$array [$var->getName()] = stream_get_contents($array [$var->getName()]);
				}
	
				$var->setValue ( $array [$var->getName()]);
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
	
	
	public function getDbAdapter() {
		return $this->adapter;
	}
	
	public function setProfiler($profiler){
		$this->adapter->setProfiler($profiler);
	}
	
	public function initialize() {
		if ($this->isInitialized) {
			return false;
		}

		if(method_exists($this, 'initializedObjectDb')) {
			call_user_func_array(array($this, 'initializedObjectDb'), array());
			$this->isInitialized = true;
			return true;
		}else{
			throw new \Exception(sprintf('The required method "%s" does not exist for %s', 'initializedObjectDb', get_class($this)));
		}
		
	}
	
	public function getMetadata(){
		
		$metadata = new \Zend\Db\Metadata\Metadata($this->adapter);
		
		return $metadata; 
	}
	
	
	public function insert(){
		$this->initialize();
		
		$rowGateway = $this->getRowGateway();
		
		$rowGateway->populate($this->toArray($this->columns), false);
		$rowGateway->save();
		$this->populate($rowGateway->toArray());
	}
	
	
	public function update(){
		$this->initialize();
		
		$this->rowGateway->populate($this->toArray($this->columns), true);
		$this->rowGateway->save();
		$this->populate($this->rowGateway->toArray());
	}
	
	public function delete(){
		$this->initialize();
		
		$this->rowGateway->populate($this->toArray(), true);
		$this->rowGateway->delete();
	}
	
	public function listAll(){
		$this->initialize();
		
		$strSQL = "SELECT * FROM ". $this->tableName;

		$this->resultSet = $this->adapter->query($strSQL)->execute();
		
		$this->resultSet->buffer();
		return $this->resultSet->count();
		
	}
	
	public function loadById($id){
		$this->initialize();
		
		$strSQL = "SELECT * FROM ". $this->tableName ." WHERE ". $this->primaryKeyColumn ." = ". $id;

		$this->resultSet = $this->adapter->query($strSQL)->execute();
		
		$this->resultSet->buffer();
		
// 		echo "<br>ResultSet Key: ".$this->resultSet->key();
// 		echo "<br>ResultSet Count: ".$this->resultSet->count();
// 		echo "<br>ResultSet Current: ";
// 		print_r($this->resultSet->current());
		
		
		if ($this->resultSet->count() === 1){
			$this->populate($this->resultSet->current());
			return true;
		}
		else {
			return false;
		}
		
	}
	
	public function loadByQuery($strSQL ){
		$this->initialize();
		
		$this->resultSet = $this->adapter->query($strSQL)->execute();
		$this->resultSet->buffer();
		
		return $this->resultSet->count();
	}
	
	public function count(){
		if(isset($this->resultSet)){
			return $this->resultSet->count();	
		}else{
		return 0;	
		}
		
	}
	
	
	public function next(){
		$this->clean();
		if ($this->resultSet->count() >= 1){
				
			if ($this->resultSet->valid()){
// 				echo "<br>ResultSet Key: ".$this->resultSet->key();
// 				echo "<br>ResultSet Count: ".$this->resultSet->count();
// 				echo "<br>ResultSet Current: ";
// 				print_r($this->resultSet->current());
				
				$this->data = $this->resultSet->current();
				$this->populate( $this->data );
				$this->resultSet->next();
				return true;
			}
		}
		else {
			return false;
		}
		
	}
	
	public function clean() {
		$vars = $this->vars;
	
			
		if (is_array($vars)){
			foreach ( $vars as $var ){
				$var->setValue('');
			}
		}	
	}
	public function rewind(){
	
				$this->resultSet->rewind();
				
				$this->data = array();

				foreach($this->vars as $column){
					$column->setValue(null);
				}
				
				return true;	
		

	}
	
	
	/**
     * __get
     *
     * @param  string $name
     * @return mixed
     */
    public function __get($name)
    {
    	
        if (array_key_exists($name, $this->data)) {
        	// echo '<br> Key: '. $column->getName();
        	$columnObject = new ColumnObject($name);
        	$columnObject->setValue($this->data[$name]);
        	$this->vars[$name] = $columnObject;
        	$this->{$name} = $columnObject;
            return $this->vars[$name];
        } else {
            throw new \InvalidArgumentException('Not a valid column in this row: ' . $name);
        }
    }
	
}

