<?php

class Application_Form_Employee extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
        
        
        // Add the comment element
        $this->addElement('text', 'Name', array(
        		'label'      => 'name:',
        		'required'   => true,
        		'validators' => array(
        				array('validator' => 'StringLength', 'options' => array(0, 10))
        		)
        ));
        
        
        $this->addElement('text', 'Email', array(
        		'label'      => 'email:',
        		'required'   => true,
        		'filters'    => array('StringTrim'),
        		'validators' => array(
        				'EmailAddress',
        		)
        ));
        
        $this->addElement('text', 'Phone', array(
        		'label'      => 'Phone:',
        		'required'   => true,
        		'filters'    => array('StringTrim')
        		)
        );
        
        $this->addElement('text', 'BankCardOwner', array(
        		'label'      => 'BankCardOwner:',
        		'required'   => false,
        		'validators' => array(
        				array('validator' => 'StringLength', 'options' => array(0, 10))
        		)
        ));
        
        $this->addElement('text', 'BankCardOwnerId', array(
        		'label'      => 'BankOwnerOwnerID:',
        		'required'   => false,
        		'validators' => array(
        				array('validator' => 'StringLength', 'options' => array(0, 10))
        		)
        ));
        
        $this->addElement('text', 'BankcardID', array(
        		'label'      => 'BankCardID:',
        		'required'   => true,
        		'validators' => array(
        				array('validator' => 'StringLength', 'options' => array(0, 24))
        		)
        ));
        
        // Add a captcha
        $this->addElement('captcha', 'captcha', array(
        		'label'      => 'Please enter the 5 letters displayed below:',
        		'required'   => true,
        		'captcha'    => array(
        				'captcha' => 'Figlet',
        				'wordLen' => 5,
        				'timeout' => 300
        		)
        ));
        
        // Add the submit button
        $this->addElement('submit', 'submit', array(
        		'ignore'   => true,
        		'label'    => 'ADd Employee',
        ));
        
        // And finally add some CSRF protection
        $this->addElement('hash', 'csrf', array(
        		'ignore' => true,
        ));
        }
}

