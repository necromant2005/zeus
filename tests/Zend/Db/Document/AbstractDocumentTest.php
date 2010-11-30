<?php
namespace Test;

require_once __DIR__ . '/_files/AbstractCollectionMock.php';

require_once __DIR__ . '/_files/AbstractDocumentMock.php';

use Zend\Db\Document as DbDocument;

class AbstractDocumentTest extends \PHPUnit_Framework_TestCase
{
    public function testInit()
    {
        $stub = $this->getMockForAbstractClass('\\Zend\\Db\\Document\\AbstractAdapter');
        $document = new AbstractDocumentMock(new AbstractCollectionMock($stub, 'test'), array('_id'=>'132', 'name'=>'jo'));
    }
}

