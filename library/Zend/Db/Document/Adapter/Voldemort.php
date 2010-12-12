<?php
namespace Zend\Db\Document\Adapter;

use Zend\Db\Document as DbDocument;

class Voldemort extends DbDocument\AbstractAdapter
{
    protected function _connect()
    {
        if ($this->isConnected()) return;
        $this->_connection = fsockopen($this->_options['host'], $this->_options['port'], $errno, $errstr);
        if (!is_resource($this->_connection)) {
            throw new \Exception($errstr, $errno);
        }
        fwrite($this->_connection, 'pb0');
        if (fread($this->_connection, 2)!='ok') throw new \Exception('Server doent accept protocol');
    }

    public function getCollection($name)
    {

    }
}

