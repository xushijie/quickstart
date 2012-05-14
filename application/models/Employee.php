<?php

class Application_Model_Employee
{
	protected $_id;
	protected $_name;
	protected $_bankOwner;
	protected $_bankOwnerID;
	protected $_bankcardID;
	protected $_startDate;
	protected $_endDate;
	protected $_isExpired;
	protected $_email;
	protected $_phone;
	
	/**
	 * @return the $_email
	 */
	public function getEmail() {
		return $this->_email;
	}

	/**
	 * @return the $_phone
	 */
	public function getPhone() {
		return $this->_phone;
	}

	/**
	 * @param field_type $_email
	 */
	public function setEmail($_email) {
		$this->_email = $_email;
	}

	/**
	 * @param field_type $_phone
	 */
	public function setPhone($_phone) {
		$this->_phone = $_phone;
	}

	/**
	 * @return the $_startDate
	 */
	public function getStartDate() {
		return $this->_startDate;
	}

	/**
	 * @return the $_endDate
	 */
	public function getEndDate() {
		return $this->_endDate;
	}

	/**
	 * @return the $_isExpired
	 */
	public function getIsExpired() {
		return $this->_isExpired;
	}

	/**
	 * @param field_type $_startDate
	 */
	public function setStartDate($_startDate) {
		$this->_startDate = $_startDate;
	}

	/**
	 * @param field_type $_endDate
	 */
	public function setEndDate($_endDate) {
		$this->_endDate = $_endDate;
	}

	/**
	 * @param field_type $_isExpired
	 */
	public function setIsExpired($_isExpired) {
		$this->_isExpired = $_isExpired;
	}

	/**
	 * @return the $_id
	 */
	public function getId() {
		return $this->_id;
	}

	/**
	 * @return the $_name
	 */
	public function getName() {
		return $this->_name;
	}

	/**
	 * @return the $_bankOwner
	 */
	public function getBankOwner() {
		return $this->_bankOwner;
	}

	/**
	 * @return the $_backOwnerID
	 */
	public function getBankOwnerID() {
		return $this->_bankOwnerID;
	}

	/**
	 * @return the $_backcardID
	 */
	public function getBankcardID() {
		return $this->_bankcardID;
	}

	/**
	 * @param field_type $_id
	 */
	public function setId($_id) {
		$this->_id = $_id;
	}

	/**
	 * @param field_type $_name
	 */
	public function setName($_name) {
		$this->_name = $_name;
	}

	/**
	 * @param field_type $_bankOwner
	 */
	public function setBankOwner($_bankOwner) {
		$this->_bankOwner = $_bankOwner;
	}

	/**
	 * @param field_type $_backOwnerID
	 */
	public function setBankOwnerID($_backOwnerID) {
		$this->_bankOwnerID = $_backOwnerID;
	}

	/**
	 * @param field_type $_backcardID
	 */
	public function setBankcardID($_backcardID) {
		$this->_bankcardID = $_backcardID;
	}

	public function __construct(array $options = null)
	{
		if (is_array($options)) {
			$this->setOptions($options);
		}
	}
	
	public function __set($name, $value)
	{
		$method = 'set' . $name;
		if (('mapper' == $name) || !method_exists($this, $method)) {
			throw new Exception('Invalid Employee property');
		}
		$this->$method($value);
	}
	
	public function __get($name)
	{
		$method = 'get' . $name;
		if (('mapper' == $name) || !method_exists($this, $method)) {
			throw new Exception('Invalid Employee property');
		}
		return $this->$method();
	}
	
	public function setOptions(array $options)
	{
		$methods = get_class_methods($this);
		foreach ($options as $key => $value) {
			$method = 'set' . ucfirst($key);
			if (in_array($method, $methods)) {
				$this->$method($value);
			}
		}
		return $this;
	}

}

