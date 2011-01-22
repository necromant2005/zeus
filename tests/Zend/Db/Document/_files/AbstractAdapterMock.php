<?php
namespace Test;

use Zend\Db\Document as DbDocument;

require_once __DIR__ . '/AbstractCollectionMock.php';

class AbstractAdapterMock extends DbDocument\AbstractAdapter
{
    public function _connect()
    {
        if ($this->isConnected()) return ;
        $this->_connection = 'something';
    }

    public function getCollection($name)
    {
         return new AbstractCollectionMock($this, $name);
    }

    public function findOne($collectionName, $query, array $fields=array())
    {
        return array($collectionName, $query, $fields);
    }

    public function find($collectionName, $query, array $fields=array())
    {
        return array($collectionName, $query, $fields);
    }
}

