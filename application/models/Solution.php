<?php

class Application_Model_Solution
{
	/**
	 * @var unknown_type
	 */
	protected $inventor;
	/**
	 * @var unknown_type
	 */
	protected $title;
	/**
	 * @var unknown_type
	 */
	protected $RFI;
	/**
	 * @var unknown_type
	 */
	protected $accept;
	/**
	 * @var unknown_type
	 */
	protected $submitDate;
	
	protected $id;
	/**
	 * @return the $id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @param field_type $id
	 */
	public function setId($id) {
		$this->id = $id;
	}

	/**
	 * @return the $_inventor
	 */
	public function getInventor() {
		return $this->inventor;
	}

	/**
	 * @return the $_title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @return the $_RFI
	 */
	public function getRFI() {
		return $this->RFI;
	}

	/**
	 * @return the $_accept
	 */
	public function getAccept() {
		return $this->accept;
	}

	/**
	 * @return the $_submitDate
	 */
	public function getSubmitDate() {
		return $this->submitDate;
	}

	/**
	 * @param unknown_type $_inventor
	 */
	public function setInventor($_inventor) {
		$this->inventor = $_inventor;
	}

	/**
	 * @param unknown_type $_title
	 */
	public function setTitle($_title) {
		$this->title = $_title;
	}

	/**
	 * @param unknown_type $_RFI
	 */
	public function setRFI($_RFI) {
		$this->RFI = $_RFI;
	}

	/**
	 * @param unknown_type $_accept
	 */
	public function setAccept($_accept) {
		$this->accept = $_accept;
	}

	/**
	 * @param unknown_type $_submitDate
	 */
	public function setSubmitDate($_submitDate) {
		$this->submitDate = $_submitDate;
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
			throw new Exception('Invalid Solution property');
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

