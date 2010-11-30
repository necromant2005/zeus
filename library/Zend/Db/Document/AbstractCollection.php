<?php
namespace Zend\Db\Document;

abstract class AbstractCollection
{
    protected $_adapter = null;

    protected $_name = '';

    public function __construct(AbstractAdapter $adapter, $name)
    {
        $this->_adapter = $adapter;
        $this->_name = $name;
    }

    public function get($name)
    {
        return $this->_adapter->get($this->_name, $name);
    }

    public function put($name, array $data)
    {
        return $this->_adapter->put($this->_name, $name, $data);
    }

    public function post(array $data)
    {
        return $this->_adapter->post($this->_name, $data);
    }

    public function delete($name)
    {
        return $this->_adapter->delete($this->_name, $name);
    }

    public function findOne()
    {}

    public function findAll()
    {}
}

