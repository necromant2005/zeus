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

    public function testMagicGet()
    {
        $stub = $this->getMockForAbstractClass('\\Zend\\Db\\Document\\AbstractAdapter');
        $document = new AbstractDocumentMock(new AbstractCollectionMock($stub, 'test'), array('_id'=>'132', 'name'=>'jo'));
        $this->assertEquals($document->name, 'jo');
    }

    public function testMagicSetId()
    {
        $stub = $this->getMockForAbstractClass('\\Zend\\Db\\Document\\AbstractAdapter');
        $document = new AbstractDocumentMock(new AbstractCollectionMock($stub, 'test'), array());
        $document->_id = 24;
        $this->assertEquals($document->getId(), 24);
    }

    public function testMagicSet()
    {
        $stub = $this->getMockForAbstractClass('\\Zend\\Db\\Document\\AbstractAdapter');
        $document = new AbstractDocumentMock(new AbstractCollectionMock($stub, 'test'), array('_id'=>'132', 'name'=>'jo'));
        $document->age = 24;
        $this->assertEquals($document->age, 24);
    }

    public function testMagicIsSet()
    {
        $stub = $this->getMockForAbstractClass('\\Zend\\Db\\Document\\AbstractAdapter');
        $document = new AbstractDocumentMock(new AbstractCollectionMock($stub, 'test'), array('_id'=>'132', 'name'=>'jo'));
        $this->assertTrue(isset($document->name));
    }

    public function testMagicIsSetNoExistsElement()
    {
        $stub = $this->getMockForAbstractClass('\\Zend\\Db\\Document\\AbstractAdapter');
        $document = new AbstractDocumentMock(new AbstractCollectionMock($stub, 'test'), array('_id'=>'132', 'name'=>'jo'));
        $this->assertFalse(isset($document->age));
    }

    public function testToArray()
    {
        $stub = $this->getMockForAbstractClass('\\Zend\\Db\\Document\\AbstractAdapter');
        $document = new AbstractDocumentMock(new AbstractCollectionMock($stub, 'test'), array('_id'=>'132', 'name'=>'jo'));
        $this->assertEquals($document->toArray(), array('name'=>'jo'));
    }

    public function testSetFromArray()
    {
        $stub = $this->getMockForAbstractClass('\\Zend\\Db\\Document\\AbstractAdapter');
        $document = new AbstractDocumentMock(new AbstractCollectionMock($stub, 'test'), array('_id'=>'132', 'name'=>'jo'));
        $result = $document->setFromArray(array('name'=>'peter', 'age'=>24));
        $this->assertType(get_class($document), $result);
        $this->assertEquals($document->toArray(), array('name'=>'peter', 'age'=>24));
    }

    public function testSetFromArrayWithId()
    {
        $stub = $this->getMockForAbstractClass('\\Zend\\Db\\Document\\AbstractAdapter');
        $document = new AbstractDocumentMock(new AbstractCollectionMock($stub, 'test'), array('_id'=>'132', 'name'=>'jo'));
        $result = $document->setFromArray(array('_id'=>123, 'name'=>'peter', 'age'=>24));
        $this->assertType(get_class($document), $result);
        $this->assertEquals($document->getId(), 123);
        $this->assertEquals($document->toArray(), array('name'=>'peter', 'age'=>24));
    }
}

