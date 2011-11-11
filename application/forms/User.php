<?php

class Application_Form_User extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
    	
      // Set the method for the display form to POST

        $this->setMethod('post');
        
        // Add an email element
        $this->addElement('text', 'email', array(
            'label'      => 'Your email address:',
            'required'   => true,
            'filters'    => array('StringTrim'),
            'validators' => array(
                'EmailAddress',
            )
        ));
        
        $this->addElement('text', 'FirstName', array(
            'label'      => 'firstName:',
            'required'   => true,
            'filters'    => array('StringTrim')            
        ));
        
        $this->addElement('text', 'LastName', array(
            'label'      => 'lastName:',
            'required'   => true,
            'filters'    => array('StringTrim')            
        ));
        
        $this->addElement('text', 'UserName', array(
            'label'      => 'userName:',
            'required'   => true,
            'filters'    => array('StringTrim')            
        ));
        

        // Add the comment element
        $this->addElement('textarea', 'comment', array(
            'label'      => 'Please Comment:',
            'required'   => true,
            'validators' => array(
                array('validator' => 'StringLength', 'options' => array(0, 20))
                )
        ));

        // Add a captcha
//        $this->addElement('captcha', 'captcha', array(
//            'label'      => 'Please enter the 5 letters displayed below:',
//            'required'   => true,
//            'captcha'    => array(
//                'captcha' => 'Figlet',
//                'wordLen' => 5,
//                'timeout' => 300
//            )
//        ));

        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Sign',
        ));

        // And finally add some CSRF protection
        $this->addElement('hash', 'csrf', array(
            'ignore' => true,
        ));
    }


}

