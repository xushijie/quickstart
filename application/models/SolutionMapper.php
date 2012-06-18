<?php

class Application_Model_SolutionMapper
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
			$this->setDbTable('Application_Model_DbTable_Solution');
		}
		return $this->_dbTable;
	}
	
	public function save(Application_Model_Solution $solution)
	{
		$data = array(
				'inventor'   => $solution->getInventor(),
				'SR_title' => $solution->getTitle(),
				'SR_RFI' => $solution->getRFI(),
				'SR_accept' => $solution->getAccept(),
				'SR_submit_date' =>$solution->getSubmitDate(),
				'id' => $solution->getId()
		);
	
		if (null === ($id = $solution->getId())) {
			unset($data['id']);
			$this->getDbTable()->insert($data);
		} else {
			$this->getDbTable()->update($data, array('id = ?' => $id));
		}
	}
	
	public function find($id, Application_Model_Solution $solution)
	{
		$result = $this->getDbTable()->find($id);
		if (0 == count($result)) {
			return;
		}
		$row = $result->current();
		$solution->setId($row->id);
		$solution->setInventor($row->inventor);
	}
	
	public function fetchAll()
	{
		$resultSet = $this->getDbTable()->fetchAll();
		$entries   = array();
		foreach ($resultSet as $row) {
			$entry = new Application_Model_Solution();
			$entry->setInventor($row->inventor);
			$entry->setTitle($row->SR_title);
			$entry->setRFI($row->SR_RFI);
			$entry->setId($row->id);
			$entry->setAccept($row->SR_accpet);
			$entry->setSubmitDate($row->SR_submit_date);
			$entries[] = $entry;
		}
		return $entries;
	}
	

}

