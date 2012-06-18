<?php
/**
 * Zsamer Framework
 *
 * @category   Zsamer
 * @package    Zsamer_Db
 * @subpackage Table
 * @copyright  Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC (http://www.bolsadeideas.cl)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Zsamer_Db_Table_Orm
 *
 * It extends Zend_Db_Table_Abstract class to provide more functionality for ORM
 * Object-relational mapping (aka ORM, O/RM, and O/R mapping)
 *
 * @author Andres Guzman F. <aguzman@bolsadeideas.cl>
 */

/**
 * @see Zend_Db_Table_Abstract
 */
require_once 'Zend/Db/Table/Abstract.php';

abstract class Zsamer_Db_Table_Orm extends Zend_Db_Table_Abstract
{
	protected $_rowClass = 'Zsamer_Db_Table_Row_Orm';

	public function findAll()
	{
		return $this->fetchAll();
	}

	public function findById($id)
	{
		return $this->find($id)->current();
	}

	public function getReferenceMapOrm()
	{
		return $this->_referenceMap;
	}

	public function getReferenceMapOrmKey()
	{
		return array_keys($this->_referenceMap);
	}

}
