<?php
namespace Zend\Db\Document\Adapter;

use Zend\Db\Document as DbDocument;

class Mongo extends DbDocument\AbstractAdapter
{
    public function _connect()
    {
        if ($this->isConnected()) return;
        $this->_connection = new \Mongo("mongodb://" . $this->_options['host'] . ':' . $this->_options['port'], array("connect" => true));
        $this->_connection->selectDB($this->_options['dbname']);
    }

    public function getCollection($name)
    {

    }
}

