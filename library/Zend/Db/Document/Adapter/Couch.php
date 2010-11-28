<?php
namespace Zend\Db\Document\Adapter;

use Zend\Db\Document as DbDocument;

class Couch extends DbDocument\AbstractAdapter
{
    public function _connect()
    {
        if ($this->isConnected()) return;
        $this->_connection = new \Zend\Rest\Client\RestClient('http://'
            . $this->_options['host'] . ':' . $this->_options['port']
            . '/' . $this->_options['dbname']);
    }

    public function getCollection($name)
    {

    }
}

