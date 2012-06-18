<?php
/**
 * Zsamer Framework
 *
 * @category   Zsamer
 * @package    Zsamer_Db
 * @subpackage Table_Row_Orm
 * @copyright  Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC (http://www.bolsadeideas.cl)
 */


/**
 * Zsamer_Db_Table_Row_Orm
 *
 * It extends Zend_Db_Table_Row_Abstract class Entity to provide more functionality for ORM
 * Object-relational mapping (aka ORM, O/RM, and O/R mapping)
 *
 * @author Andres Guzman F. <aguzman@bolsadeideas.cl>
 */


/**
 * @see Zend_Db_Table_Row_Abstract
 */
require_once 'Zend/Db/Table/Row/Abstract.php';

class Zsamer_Db_Table_Row_Orm extends Zend_Db_Table_Row_Abstract
{
	protected static $_underscoreCache = array();

	protected static $_camelizeCache = array();

	protected static $_objectPersistentCache = array();

	protected static $_objectHasRelationship = array();

	protected $_dataObject = array();

	protected $_dataObjectCollection = array();

	/**
	 * Saves the properties to the database.
	 *
	 * This performs an intelligent insert/update, and reloads the
	 * properties with fresh data from the table on success.
	 *
	 * @return mixed The primary key value(s), as an associative array if the
	 *     key is compound, or a scalar if the key is single-column.
	 */
	public function save()
	{
		$this->_getTable()->getAdapter()->beginTransaction();
		try	{
			$result = parent::save();
			$this->_getTable()->getAdapter()->commit();
			return $result;
		} catch (Exception $e){
			$this->_getTable()->getAdapter()->rollBack();
			throw $e;
		}
	}

	/**
	 * Deletes existing rows.
	 *
	 * @return int The number of rows deleted.
	 */
	public function delete()
	{
		$this->_getTable()->getAdapter()->beginTransaction();
		try {
			$result = parent::delete();
			$this->_getTable()->getAdapter()->commit();
			return $result;
		} catch (Exception $e){
			$this->_getTable()->getAdapter()->rollBack();
			throw $e;
		}
	}

	/**
	 * Allows pre-insert logic to be applied to row.
	 * Subclasses may override this method.
	 *
	 * @return void
	 */
	protected function _insert()
	{
		if (array_key_exists('created_at', $this->_data)) {
			$this->setCreatedAt(new Zend_Db_Expr('NOW()'));
		}

		if (array_key_exists('updated_at', $this->_data)) {
			$this->setUpdatedAt(new Zend_Db_Expr('NOW()'));
		}

		$this->_setupReferenceMap();
	}

	/**
	 * Allows post-insert logic to be applied to row.
	 * Subclasses may override this method.
	 *
	 * @return void
	 */
	protected function _postInsert()
	{
		$this->_setupDependentTables();
	}

	/**
	 * Allows pre-update logic to be applied to row.
	 * Subclasses may override this method.
	 *
	 * @return void
	 */
	protected function _update()
	{
		if (array_key_exists('updated_at', $this->_data)) {
			$this->setUpdatedAt(new Zend_Db_Expr('NOW()'));
		}

		$this->_setupReferenceMap();
	}

	/**
	 * Allows post-update logic to be applied to row.
	 * Subclasses may override this method.
	 *
	 * @return void
	 */
	protected function _postUpdate()
	{
		$this->_setupDependentTables();
	}

	/**
	 * Allows pre-delete logic to be applied to row.
	 * Subclasses may override this method.
	 *
	 * @return void
	 */
	protected function _delete()
	{
	}

	/**
	 * Allows post-delete logic to be applied to row.
	 * Subclasses may override this method.
	 *
	 * @return void
	 */
	protected function _postDelete()
	{
	}

	protected function _setupReferenceMap()
	{
		$referenceMap = $this->_getTable()->getReferenceMapOrm();

		foreach($referenceMap as $map => $info){
			$methodParent = '_ge'.$map;

			$parentObject = $this->{$methodParent}();

			if($parentObject instanceof Zend_Db_Table_Row_Abstract)
			{
				if ($parentObject->isNew()) {
					$parentObject->save();
				}

				$setParentKeyMethod = 'set'.$this->_camelizeColumn(current($info['columns']));

				$getParentKeyMethod = 'get'.$this->_camelizeColumn(current($info['refColumns']));

				$this->$setParentKeyMethod($parentObject->$getParentKeyMethod());
			}
		}
	}

	protected function _setupDependentTables()
	{
		$dependentTables = $this->_getTable()->getDependentTables();

		$className = $this->getTableClass();

		foreach($dependentTables as $table)
		{
			$chieldClassName = $this->_getTableClassName($table);
			$methodChield = '_ge'.$chieldClassName;

			$chieldObject = $this->{$methodChield}();

			if($chieldObject instanceof Zend_Db_Table_Row_Abstract)
			{
				$referenceMap = $chieldObject->getTable()->getReference($className);

				$setParentKeyMethod = 'set'.$this->_camelizeColumn(current($referenceMap['columns']));
				$getParentKeyMethod = 'get'.$this->_camelizeColumn(current($referenceMap['refColumns']));

				$chieldObject->$setParentKeyMethod($this->$getParentKeyMethod());
				$chieldObject->save();

			} else if(isset($this->_dataObjectCollection[strtolower($chieldClassName)])){
				$objectCollection = $this->_dataObjectCollection[strtolower($chieldClassName)];

				$referenceMap = $objectCollection[0]->getTable()->getReference($className);

				$setParentKeyMethod = 'set'.$this->_camelizeColumn(current($referenceMap['columns']));
				$getParentKeyMethod = 'get'.$this->_camelizeColumn(current($referenceMap['refColumns']));

				foreach($objectCollection as $object)
				{
					$object->$setParentKeyMethod($this->$getParentKeyMethod());
					$object->save();
				}
			}
		}
	}

	/**
	 * Overwrite data in the object.
	 *
	 * $key can be string or array.
	 * If $key is string, the attribute value will be overwritten by $value
	 *
	 * If $key is an array, it will overwrite all the data in the object.
	 *
	 * $isChanged will specify if the object needs to be saved after an update.
	 *
	 * @param string|array $key
	 * @param mixed $value
	 * @param boolean $isChanged
	 * @return Zsamer_Db_Table_Row_Abstract
	 */
	public function setData($key, $value='')
	{
		$columnName = $key;

		if (array_key_exists($columnName, $this->_data)) {
			$this->_modifiedFields[$columnName] = true;
			$this->_data[$columnName] = $value;
			return $this;
		}

		if ($value instanceof Zend_Db_Table_Row_Abstract)
		{
			$this->_hasRelationship($columnName);

			$this->_dataObject[$columnName] = $value;
			return $this;
		}

		require_once 'Zend/Db/Table/Row/Exception.php';
		throw new Zend_Db_Table_Row_Exception("Specified column \"$columnName\" is not in the row");
	}

	public function addData($key, $value=null)
	{
		$columnName = $key;

		if (!$value instanceof Zend_Db_Table_Row_Abstract) {
			require_once 'Zend/Db/Table/Row/Exception.php';
			throw new Zend_Db_Table_Row_Exception("Specified column \"$columnName\" is not instance of Zend_Db_Table_Row_Abstract");
		}

		$this->_hasRelationship($columnName);

		$this->_dataObjectCollection[$columnName][] = $value;
		return $this;
	}

	/**
	 * Retrieves data from the object
	 *
	 * If $key is empty will return all the data as an array
	 * Otherwise it will return value of the attribute specified by $key
	 *
	 * If $index is specified it will assume that attribute data is an array
	 * and retrieve corresponding member.
	 *
	 * @param string $key
	 * @param string|int $index
	 * @return mixed
	 */
	public function getData($columnName = null, Zend_Db_Table_Select $select = null)
	{
		if (null === $columnName) {
			return $this->_data;
		}

		if (array_key_exists($columnName, $this->_data)) {
			return $this->_data[$columnName];
		}

		if (array_key_exists($columnName, $this->_dataObject)) {
			if ($this->_dataObject[$columnName] instanceof Zend_Db_Table_Row_Abstract) {
				return $this->_dataObject[$columnName];
			}
		}

		$isCollection = false;
		if('s' === substr($columnName, -1)){
			$columnName = substr($columnName, 0, strlen($columnName)-1);
			$isCollection = true;
		}

		$columnNameCriteria = $columnName . 'LastCriteria';

		if (isset(self::$_objectPersistentCache[$columnName]) && $this->_equalsCriteria($columnNameCriteria, $select)) {
			return self::$_objectPersistentCache[$columnName];
		}

		$dependentTables = $this->_getTable()->getDependentTables();

		foreach($dependentTables as $table)
		{
			$chieldClassName = $this->_getTableClassName($table);
			$chieldClassName = $this->_underscore($chieldClassName);

			if ($chieldClassName === $columnName) {
				if($isCollection === false){
					self::$_objectPersistentCache[$columnName] = $this->findDependentRowset($table, null, $select)->current();
				} else{
					self::$_objectPersistentCache[$columnName] = $this->findDependentRowset($table, null, $select);
				}

				self::$_objectPersistentCache[$columnNameCriteria] = $select;

				return self::$_objectPersistentCache[$columnName];
				break;
			}

		}

		$referenceMap = $this->_getTable()->getReferenceMapOrm();

		foreach($referenceMap as $map => $info)
		{
			if (strtolower($map) === $columnName) {
				$table = $info['refTableClass'];
				self::$_objectPersistentCache[$columnName] = $this->findParentRow($table, null, $select);
				self::$_objectPersistentCache[$columnNameCriteria] = $select;
				return self::$_objectPersistentCache[$columnName];
				break;
			}
		}

		//return null;
		require_once 'Zend/Db/Table/Row/Exception.php';
		throw new Zend_Db_Table_Row_Exception("Specified column \"$columnName\" is not in the row");
	}

	/**
	 * Retrieves data from the object
	 *
	 * If $key is empty will return all the data as an array
	 * Otherwise it will return value of the attribute specified by $key
	 *
	 * If $index is specified it will assume that attribute data is an array
	 * and retrieve corresponding member.
	 *
	 * @param string $key
	 * @param string|int $index
	 * @return mixed
	 */
	protected function _getData($columnName = null)
	{
		if (null === $columnName) {
			return $this->_data;
		}

		if (!array_key_exists($columnName, $this->_data)) {

			if (array_key_exists($columnName, $this->_dataObject)) {
				if ($this->_dataObject[$columnName] instanceof Zend_Db_Table_Row_Abstract) {
					return $this->_dataObject[$columnName];
				}
			}
			return null;
		}

		return $this->_data[$columnName];
	}

	protected function _hasRelationship($columnName)
	{
		if (isset(self::$_objectHasRelationship[$columnName])) {
			return $this;
		}

		self::$_objectHasRelationship[$columnName] = null;

		$columnCamelName = $this->_camelizeColumn($columnName);

		if(in_array($columnCamelName, $this->_getTable()->getReferenceMapOrmKey())){
			self::$_objectHasRelationship[$columnName] = true;
		} else {

			$dependentTables = $this->_getTable()->getDependentTables();

			foreach($dependentTables as $table)
			{
				$chieldClassName = $this->_getTableClassName($table);

				if($chieldClassName === $columnCamelName){
					self::$_objectHasRelationship[$columnName] = true;
					break;
				}

			}
		}

		if(null === self::$_objectHasRelationship[$columnName]){
			require_once 'Zend/Db/Table/Row/Exception.php';
			throw new Zend_Db_Table_Row_Exception("Specified object \"$columnCamelName\" has no Relationship with ".$this->getTableClass());
		}

		return $this;
	}

	/**
	 * Unset data from the object.
	 *
	 * $key can be a string only. Array will be ignored.
	 *
	 * $isChanged will specify if the object needs to be saved after an update.
	 *
	 * @param string $key
	 * @param boolean $isChanged
	 * @return Zsamer_Db_Table_Row_Abstract
	 */
	public function unsetData($key=null)
	{
		if (is_null($key)) {
			$this->_data = array();
		} else {
			unset($this->_data[$key]);
		}
		return $this;
	}

	/**
	 * If $key is empty, checks whether there's any data in the object
	 * Otherwise checks if the specified attribute is set.
	 *
	 * @param string $key
	 * @return boolean
	 */
	public function hasData($key='')
	{
		if (empty($key) || !is_string($key)) {
			return !empty($this->_data);
		}
		return isset($this->_data[$key]);
	}

	/**
	 * checks whether the object is empty
	 *
	 * @return boolean
	 */
	public function isEmpty()
	{
		if(empty($this->_data)) {
			return true;
		}
		return false;
	}

	/**
	 * checks whether the object is empty
	 *
	 * @return boolean
	 */
	public function isNew()
	{
		return empty($this->_cleanData);
	}

	public function getCreatedAt()
	{
		$createdAt = $this->_getData('created_at');

		if ($createdAt === null) {
			return null;
		}

		if ($createdAt === '0000-00-00') {
			// while technically this is not a default value of NULL,
			// this seems to be closest in meaning.
			return null;
		}

		if ($createdAt === '0000-00-00 00:00:00') {
			return null;
		}

		return $createdAt;
	}

	public function getUpdatedAt()
	{
		$updatedAt = $this->_getData('updated_at');

		if ($updatedAt === null) {
			return null;
		}

		if ($updatedAt === '0000-00-00') {
			// while technically this is not a default value of NULL,
			// this seems to be closest in meaning.
			return null;
		}

		if ($updatedAt === '0000-00-00 00:00:00') {
			return null;
		}

		return $updatedAt;
	}

	protected function _getLastCriteria($columnNameCriteria)
	{
		if(isset(self::$_objectPersistentCache[$columnNameCriteria])){
			return self::$_objectPersistentCache[$columnNameCriteria];
		}
		return null;
	}

	/**
	 * Converts field names for setters and geters
	 *
	 * $this->setMyField($value) === $this->setData('my_field', $value)
	 * Uses cache to eliminate unneccessary preg_replace
	 *
	 * @param string $name
	 * @return string
	 */
	protected function _underscore($name)
	{
		if (isset(self::$_underscoreCache[$name])) {
			return self::$_underscoreCache[$name];
		}

		$result = strtolower(preg_replace('/(.)([A-Z])/', "$1_$2", $name));

		self::$_underscoreCache[$name] = $result;
		return $result;
	}

	protected function _camelizeColumn($name)
	{
		if (isset(self::$_camelizeCache[$name])) {
			return self::$_camelizeCache[$name];
		}

		$result = str_replace('_', ' ', strtolower($name));
		$result = preg_replace('/[^a-z0-9 ]/', '', $result);
		$result = str_replace(' ', '', ucwords($result));

		self::$_camelizeCache[$name] = $result;
		return $result;
	}

	protected function _getTableClassName($table = null)
	{
		if(null === $table){
			$table = $this->getTableClass();
		}

		if(strpos($table, '_') === false){
			return $table;
		}

		$tableArray = explode('_', $table);
		$className = array_pop($tableArray);
		return $className;
	}

	/**
	 * This method checks another Criteria to see if they contain
	 * the same attributes and hashtable entries.
	 * @return     boolean
	 */
	protected function _equalsCriteria($columnNameCriteria, $select)
	{
		// TODO: optimize me with early outs
		$lastCriteria = $this->_getLastCriteria($columnNameCriteria);

		//var_dump($lastCriteria->__toString() === $select->__toString());die;
		if ($lastCriteria === $select) {
			return true;
		}

		if (($select === null) || !($select instanceof Zend_Db_Select)) {
			return false;
		}

		return false;
	}

	/**
	 * Set/Get attribute wrapper
	 *
	 * @param   string $method
	 * @param   array $args
	 * @return  mixed
	 */
	public function __call($method, array $args)
	{
		try {
			return parent::__call($method, $args);
		} catch (Zend_Db_Table_Row_Exception $e){
			switch (substr($method, 0, 3)) {
				case 'get' :
					$key = $this->_underscore(substr($method,3));
					array_unshift($args, $key);
					$data = call_user_func_array(array($this, 'getData'), $args);

					return $data;
					break;

				case 'set' :
					$key = $this->_underscore(substr($method,3));
					array_unshift($args, $key);
					$data = call_user_func_array(array($this, 'setData'), $args);

					return $data;
					break;

				case 'uns' :
					$key = $this->_underscore(substr($method,3));
					array_unshift($args, $key);

					return call_user_func_array(array($this, 'unsetData'), $args);
					break;

				case 'has' :
					$key = $this->_underscore(substr($method,3));

					return isset($this->_data[$key]);
					break;

				case 'add' :
					$key = $this->_underscore(substr($method,3));
					array_unshift($args, $key);
					$data = call_user_func_array(array($this, 'addData'), $args);

					return $data;
					break;

				case '_ge' :
					$key = $this->_underscore(substr($method,3));
					array_unshift($args, $key);
					$data = call_user_func_array(array($this, '_getData'), $args);

					return $data;
					break;
			}

			throw $e;
		} catch (Exception $e) {
			throw $e;
		}
	}
}