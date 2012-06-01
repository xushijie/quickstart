<?php

use services\Data\DataService;

class EmployeeController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $employeeMapper = new Application_Model_EmployeeMapper();
        $this->view->entries = $employeeMapper->fetchAll();
    }

    public function addAction()
    {
        $request = $this->getRequest();
        $form    = new Application_Form_Employee();
        
        if ($this->getRequest()->isPost()) {
        	if ($form->isValid($request->getPost())) {
        		$comment = new Application_Model_Employee($form->getValues());
        		$comment->setIsExpired(0);
        		$mapper  = new Application_Model_EmployeeMapper();
        		$mapper->save($comment);
        		return $this->_helper->redirector('index');
        	}
        }
        
        $this->view->form = $form;
    }

    
    public function testAction(){
    	$dataService = new DataService();
    	$array = array("1","2","4");
    	foreach($array as $item){
    		$dataService->getStatus($item);
    	}
    	echo $dataService->getStatus("");
    }

}



