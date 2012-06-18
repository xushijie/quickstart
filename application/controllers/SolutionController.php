<?php

class SolutionController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    	$solution = new Application_Model_SolutionMapper();
    	$this->view->entries = $solution->fetchAll();
    }

    public function addAction()
    {
        // action body
    }


}



