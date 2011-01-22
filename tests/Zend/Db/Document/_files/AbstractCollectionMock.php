<?php
namespace Test;

use Zend\Db\Document as DbDocument;

require_once __DIR__ . '/AbstractDocumentMock.php';

class AbstractCollectionMock extends DbDocument\AbstractCollection
{

    public function get($name)
    {
        return new AbstractDocumentMock($this, array());
    }
}

