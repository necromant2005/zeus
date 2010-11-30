<?php
namespace Test;

require_once __DIR__ . '/_files/AbstractCollectionMock.php';

use Zend\Db\Document as DbDocument;

class AbstractCollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testInit()
    {
        $stub = $this->getMockForAbstractClass('\\Zend\\Db\\Document\\AbstractAdapter');
        $collection = new AbstractCollectionMock($stub, 'test');
    }

    public function testGetAdapter()
    {
        $stub = $this->getMockForAbstractClass('\\Zend\\Db\\Document\\AbstractAdapter');
        $collection = new AbstractCollectionMock($stub, 'test');
        $this->assertType(get_class($stub), $collection->getAdapter());
    }

    public function testGet()
    {
        $stub = $this->getMockForAbstractClass('\\Zend\\Db\\Document\\AbstractAdapter');
        $collection = new AbstractCollectionMock($stub, 'test');
        $document = $collection->get('test');
        $this->assertTrue($document instanceof DbDocument\AbstractDocument);
    }
}

