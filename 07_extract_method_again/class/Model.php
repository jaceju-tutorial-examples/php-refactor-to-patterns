<?php

abstract class Model
{
    /**
     * @var Dao
     */
    protected $_dao = NULL;

    public function __construct(Dao $dao)
    {
        $this->_dao = $dao;
    }

    protected $_table = 'table';

    protected $_primary = 'id';

    protected $_data = array();

    protected $_isNew = TRUE;

    /**
     *
     * @param array $data
     */
    public function create($data = array())
    {
        $this->_data = $data;
        $this->_isNew = TRUE;
    }

    public function bind($id)
    {
        $where = array(
            $this->_primary . ' = ?' => $id,
        );
        $this->_isNew = FALSE;
        $this->_data = $this->_dao->fetchRow($this->_table, $where);
    }

    public function __set($name, $value)
    {
        if (array_key_exists($name, $this->_data)) {
            $this->_data[$name] = $value;
        }
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->_data)) {
            return $this->_data[$name];
        }
    }

    public function save()
    {
        if ($this->_isNew) {
            $this->_dao->insert($this->_table, $this->_data);
        } else {
            $where = array(
                $this->_primary . ' = ?' => $this->_data[$this->_primary],
            );
            $this->_dao->update($this->_table, $this->_data, $where);
        }
    }

}
