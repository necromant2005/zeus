<?php
namespace Zend\Db\Document\Adapter;

use Zend\Db\Document as DbDocument;

class Riak extends DbDocument\AbstractAdapter
{
    protected function _connect()
    {
        if ($this->isConnected()) return;
        $this->_connection = new \Zend\Rest\Client\RestClient('http://'
            . $this->_options['host'] . ':' . $this->_options['port']
            . '/riak');
    }

    public function getCollection($name)
    {
        return new DbDocument\Collection\Riak($this, $name);
    }
}

