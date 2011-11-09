<?php

class NewsController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
         $this->view->content="hello Mynews";//保存我们的信息，在view层可以使用
    }


}

