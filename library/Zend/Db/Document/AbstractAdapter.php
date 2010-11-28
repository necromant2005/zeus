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
        $this->_connect();
        return $this->_connection;
    }

    public function isConnected()
    {
        return !is_null($this->_connection);
    }

    abstract function _connect();

    abstract function getCollection($name);
}

