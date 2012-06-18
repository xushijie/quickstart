<?php
require_once 'Zend/Db/Adapter/Pdo/Mysql.php';

class Zsamer_Db_Adapter_Pdo_Mysql extends Zend_Db_Adapter_Pdo_Mysql
{
    protected $_transactionLevel = 0;
	
    public function beginTransaction()
    {
        if ($this->_transactionLevel===0) {
            parent::beginTransaction();
        }
        $this->_transactionLevel++;
        return $this;
    }

    public function commit()
    {
        if ($this->_transactionLevel===1) {
            parent::commit();
        }
        $this->_transactionLevel--;
        return $this;
    }

    public function rollback()
    {
        if ($this->_transactionLevel===1) {
            return parent::rollback();
        }
        $this->_transactionLevel--;
        return $this;
    }
}