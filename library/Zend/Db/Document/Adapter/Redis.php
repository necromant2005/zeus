<?php
namespace Zend\Db\Document\Adapter;

use Zend\Db\Document as DbDocument;

class Redis extends DbDocument\AbstractAdapter
{
    protected function _connect()
    {
        if ($this->isConnected()) return;
        $this->_connection = fsockopen($this->_options['host'], $this->_options['port'], $errno, $errstr);
        if (!is_resource($this->_connection)) {
            throw new \Exception($errstr, $errno);
        }
        stream_set_blocking($this->_connection, false);
    }

    public function getCollection($name)
    {

    }
}

