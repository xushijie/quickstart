<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	//$this->registry = Zend_Registry::getInstance();
        //$this->view = $this->registry['view'];
        //$this->view->baseUrl = $this->_request->getBaseUrl();
    	
    }

    public function indexAction()
    {
        //$message=new message();//实例化数据库类
        //这里给变量赋值,在index.phtml模板里显示
       // $this->view->bodyTitle = '<h1>Hello World!</h1>';
        //取到所有数据.二维数组
        //$this->view->messages=$message->fetchAll()->toArray();
        //print_r( $this->view->messages);
        //echo $this->view->render('index.phtml');
    }

    public function sayHelloAction(){
        echo "hello world...";
   }
}

