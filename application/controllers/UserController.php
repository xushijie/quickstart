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

    public function addAction()
    {
        $request = $this->getRequest();
        $form    = new Application_Form_User();
 
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $user = new Application_Model_User($form->getValues());
                $mapper  = new Application_Model_UserMapper();
                $mapper->save($user);
                return $this->_helper->redirector('index');
            }
        }
 
        $this->view->form = $form;
    }


}



