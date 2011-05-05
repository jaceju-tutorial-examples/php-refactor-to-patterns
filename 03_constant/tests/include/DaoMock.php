<?php

class DaoMock extends Dao
{
    protected $_data = array();

    public function __construct($data)
    {
        $this->_data = $data;
    }

    public function fetchAll($sql)
    {
        return array_key_exists($sql, $this->_data)
             ? $this->_data[$sql]
             : array();
    }

    public function fetchRow($table, $where)
    {
        $result = array();
        if ('orders' === $table && array_key_exists('orderNumber = ?', $where)) {
            $orderNumber = $where['orderNumber = ?'];
            $result = $this->_data[$table][$orderNumber];
        }
        return $result;
    }

    public function insert($table, $data)
    {
    }

    public function update($table, $data, $where)
    {
    }

    public function delete($table, $where)
    {
    }
}