<?php

class UserController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
		$users = new Application_Model_UserMapper();
        $this->view->entries = $users->fetchAll();
        echo "hello world ";
    }


}

