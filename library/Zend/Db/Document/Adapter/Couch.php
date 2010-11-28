<?php
namespace Zend\Db\Document\Adapter;

use Zend\Db\Document as DbDocument;

class Couch extends DbDocument\AbstractAdapter
{
    public function _connect()
    {
        if ($this->isConnected()) return;

    }

    public function getCollection($name)
    {

    }
}

