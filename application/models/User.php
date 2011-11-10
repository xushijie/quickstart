<?php

class Application_Model_User
{
  	/**
  	 * Enter description here ...
  	 * @var unknown_type
  	 */
  	protected $_first_name;
    protected $_last_name;
    protected $_user_name;
    protected $_id;
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
            throw new Exception('Invalid User property');
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid User property');
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

    public function setId($id)
    {
        $this->_id = (int) $id;
        return $this;
    }
 
    public function getId()
    {
        return $this->_id;
    }
	//Other option for _set/_get methods for User field.
	
    public function setFirstName($firstName){
    	$this->_firstName = $firstName;
    }
    
    public function getFirstName(){
    	return $this->_firstName;	
    }
    
    public function setLastName($lastName){
    	$this->_last_name = $lastName;
    }
    
    public function getLastName(){
    	return $this->_last_name;
    }
    
    public function setUserName($userName){
    	$this->_user_name = $userName;
    }
    public function getUserName(){
    	return $this->_user_name;
    }
}

?>