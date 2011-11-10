<?php

class Application_Model_UserMapper
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
			$this->setDbTable('Application_Model_DbTable_User');
		}
		return $this->_dbTable;
	}

	public function save(Application_Model_User $user)
	{
		$data = array(
            'firstName'   => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'userName' => $user->getUserName(),
		);
		
		if (null === ($id = $user->getId())) {
			unset($data['id']);
			$this->getDbTable()->insert($data);
		} else {
			$this->getDbTable()->update($data, array('id = ?' => $id));
		}
	}

	public function find($id, Application_Model_Guestbook $guestbook)
	{
//		$result = $this->getDbTable()->find($id);
//		if (0 == count($result)) {
//			return;
//		}
//		$row = $result->current();
//		$guestbook->setId($row->id)
//		->setEmail($row->email)->setComment($row->comment)->setCreated($row->created);

	}

	public function fetchAll()
	{
		$resultSet = $this->getDbTable()->fetchAll();
		$entries   = array();
		foreach ($resultSet as $row) {
			$entry = new Application_Model_User();
			$entry->setId($row->id)->setFirstName($row->first_name)->setLastName($row->last_name)->setUserName($row->user_name);
			$entries[] = $entry;
		}
		return $entries;
	}

}

?>