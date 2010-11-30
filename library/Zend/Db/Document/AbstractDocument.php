<?php
namespace Zend\Db\Document;

abstract class AbstractDocument
{
    protected $_data = array();

    protected $_id = '';

    public function setId($id)
    {
        $this->_id = $id;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function __get($name)
    {
        if (!$this->__isset($name)) throw new \Exception('Property '.$name.' doesn\'t exist');
        return $this->_data[$name];
    }

    public function __set($name, $value)
    {
        return $this->_data[$name] = $value;
    }

    public function __isset($name)
    {
        return array_key_exixts($name, $this->_data);
    }
}

