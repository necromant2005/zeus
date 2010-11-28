<?php
namespace Zend\Db\Document;

abstract class AbstractAdapter
{
    protected $_options = array();

    protected $_connection = null;

    public function __construct(array $options=array())
    {
        $this->_options = $options;
    }

    public function setConnection($connection)
    {
        $this->_connection = $connection;
    }

    public function getConnection()
    {
        if (!$this->isConnected()) $this->_connect();
        return $this->_connection;
    }

    public function isConnected()
    {
        return !is_null($this->_connection);
    }

    abstract protected function _connect();

    abstract public function getCollection($name);
}

