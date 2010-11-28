<?php
namespace Test;

require_once __DIR__ . '/_files/CollectionMock.php';

use Zend\Db\Document as DbDocument;

class CollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testInit()
    {
        $stub = $this->getMockForAbstractClass('\\Zend\\Db\\Document\\AbstractAdapter');
        $collection = new CollectionMock($stub, 'test');
    }
}

