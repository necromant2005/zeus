<?php
namespace Test;

use Zend\Db\Document as DbDocument;

class MongoTest extends \PHPUnit_Framework_TestCase
{
    private function _getCollection()
    {
        $adapter = new DbDocument\Adapter\Mongo(array(
            'host' => TESTS_ZEND_DB_DOCUMENT_ADAPTER_MONGO_HOST,
            'port' => TESTS_ZEND_DB_DOCUMENT_ADAPTER_MONGO_PORT,
            'dbname' => TESTS_ZEND_DB_DOCUMENT_ADAPTER_MONGO_DATABASE,
        ));
        return $adapter->getCollection(TESTS_ZEND_DB_DOCUMENT_ADAPTER_MONGO_COLLECTION);
    }

    public function setUp()
    {
        if (!defined('TESTS_ZEND_DB_DOCUMENT_ADAPTER_MONGO_ENABLED') || !TESTS_ZEND_DB_DOCUMENT_ADAPTER_MONGO_ENABLED) {
            $this->markTestSkipped('The MongoDb extension is not available.');
        }
    }

    public function testInit()
    {
        $adapter = new DbDocument\Adapter\Mongo();
    }

    public function testGetConnection()
    {
        $adapter = new DbDocument\Adapter\Mongo(array(
            'host' => TESTS_ZEND_DB_DOCUMENT_ADAPTER_MONGO_HOST,
            'port' => TESTS_ZEND_DB_DOCUMENT_ADAPTER_MONGO_PORT,
            'dbname' => TESTS_ZEND_DB_DOCUMENT_ADAPTER_MONGO_DATABASE,
        ));
        $this->assertType('Mongo', $adapter->getConnection());
    }

    public function testGetCollection()
    {
        $adapter = new DbDocument\Adapter\Mongo(array(
            'host' => TESTS_ZEND_DB_DOCUMENT_ADAPTER_MONGO_HOST,
            'port' => TESTS_ZEND_DB_DOCUMENT_ADAPTER_MONGO_PORT,
            'dbname' => TESTS_ZEND_DB_DOCUMENT_ADAPTER_MONGO_DATABASE,
        ));
        $this->assertType('Zend\\Db\\Document\\Collection\\Mongo', $adapter->getCollection(TESTS_ZEND_DB_DOCUMENT_ADAPTER_MONGO_COLLECTION));
    }

    public function testPut()
    {
        try {
            $this->_getCollection()->put('test', array('nane'=>'peter'));
        } catch (\Exception $e) {
            return ;
        }
        $this->fail('Expect exception');
    }

    public function testPost()
    {
        $this->assertRegExp('/^[a-f0-9]{24}$/', $this->_getCollection()->post(array('nane'=>'peter')));
    }

    public function testGet()
    {
        $name = $this->_getCollection()->post(array('name'=>'peter'));
        $document = $this->_getCollection()->get($name);
        $this->assertType('Zend\\Db\\Document\\Document\\Mongo', $document);
        $this->assertEquals($document->getId(), $name);
        $this->assertEquals($document->toArray(), array('name'=>'peter'));
    }

    public function testDelete()
    {
        $name = $this->_getCollection()->post(array('name'=>'peter'));
        $this->_getCollection()->delete($name);
        $this->assertNull($this->_getCollection()->get($name));
    }
}

