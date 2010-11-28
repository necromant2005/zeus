<?php
namespace Test;

use Zend\Db\Document as DbDocument;

require_once __DIR__ . '/../../../../../library/Zend/Db/Document/AbstractAdapter.php';

require_once __DIR__ . '/CollectionMock.php';

class AbstractAdapterMock extends DbDocument\AbstractAdapter
{
    public function _connect()
    {
        $this->_connection = 'something';
    }

    public function getCollection($name)
    {
         return new CollectionMock($this, $name);
    }
}

