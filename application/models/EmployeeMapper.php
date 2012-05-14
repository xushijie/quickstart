<?php

class Application_Model_EmployeeMapper
{

	protected $_dbTable;
	
	public function setDbTable($dbTable){
		if (is_string($dbTable)) {
			$dbTable = new $dbTable();
		}
	
		if (!$dbTable instanceof Zend_Db_Table_Abstract) {
			throw new Exception('Invalid table data gateway provided');
		}
	
		$this->_dbTable = $dbTable;
		return $this;
	}
	
	public function getDbTable()
	{
		if (null === $this->_dbTable) {
			$this->setDbTable('Application_Model_DbTable_Employee');
		}
		return $this->_dbTable;
	}
	
	public function save(Application_Model_Employee $employee)
	{
		$data = array(
				'id'   => $employee->getId(),
				'name' => $employee->getName(),
				'bankOwner' => $employee->getBankOwner(),
				'bankOwnerId' => $employee->getBankOwnerID(),
				'bankcardId' =>$employee->getBankcardID(),
				'startDate' =>$employee->getStartDate(),
				'endDate' =>$employee->getEndDate(),
				'isExpired' =>$employee->getIsExpired(),
				'email'  => $employee->getEmail(),
				'phone' => $employee->getPhone(),
		);
	
		if (null === ($id = $employee->getId())) {
			unset($data['id']);
			$this->getDbTable()->insert($data);
		} else {
			$this->getDbTable()->update($data, array('id = ?' => $id));
		}
	}
	
	public function find($id, Application_Model_Employee $employee)
	{
		$result = $this->getDbTable()->find($id);
		if (0 == count($result)) {
			return;
		}
		$row = $result->current();
		$employee->setId($row->id);
		$employee->setName($row->name);
		$employee->setBankcardID($row->bankcardId);
		$employee->setBankOwnerID($row->bankOwnerId);
		$employee->setBankOwner($row->bankOwner);;
		$employee->setStartDate($row->startdate);
		$employee->setEndDate($row->endDate);
		$employee->setIsExpired($row->isExpired);
		$employee->setEmail($row->email);
		$employee->setPhone($row->phone);
	}
	
	public function fetchAll()
	{
		$resultSet = $this->getDbTable()->fetchAll();
		$entries   = array();
		foreach ($resultSet as $row) {
			$entry = new Application_Model_Employee();
			$entry->setId($row->id);
			$entry->setName($row->name);
			$entry->setBankcardID($row->bankcardID);
			$entry->setBankOwnerID($row->bankOwnerID);
			$entry->setBankOwner($row->bankOwner);
			$entry->setStartDate($row->startDate);
			$entry->setEndDate($row->endDate);
			$entry->setIsExpired($row->isExpired);
			$entry->setEmail($row->email);
			$entry->setPhone($row->phone);
			$entries[] = $entry;
		}
		return $entries;
	}
	
}

