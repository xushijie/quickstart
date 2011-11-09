<?php

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

//配置数据库参数,并连接数据库
$config=new Zend_Config_Ini('./application/configs/applocaton.ini',null, true);
Zend_Registry::set('config',$config);
$dbAdapter=Zend_Db::factory($config->general->db->adapter,

$config->general->db->config->toArray());
$dbAdapter->query('SET NAMES UTF8');
Zend_Db_Table::setDefaultAdapter($dbAdapter);
Zend_Registry::set('dbAdapter',$dbAdapter);


/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);





$application->bootstrap()
            ->run();