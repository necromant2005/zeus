<?php
namespace Test;

use Zend\Db\Document as DbDocument;

class MongoTest extends \PHPUnit_Framework_TestCase
{
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
        $adapter = new DbDocument\Adapter\Mongo(array(
            'host' => TESTS_ZEND_DB_DOCUMENT_ADAPTER_MONGO_HOST,
            'port' => TESTS_ZEND_DB_DOCUMENT_ADAPTER_MONGO_PORT,
            'dbname' => TESTS_ZEND_DB_DOCUMENT_ADAPTER_MONGO_DATABASE,
        ));
        try {
            $adapter->getCollection(TESTS_ZEND_DB_DOCUMENT_ADAPTER_MONGO_COLLECTION)
                ->put('test', array('nane'=>'peter'));
        } catch (\Exception $e) {
            return ;
        }
    }

    public function testPost()
    {
        $adapter = new DbDocument\Adapter\Mongo(array(
            'host' => TESTS_ZEND_DB_DOCUMENT_ADAPTER_MONGO_HOST,
            'port' => TESTS_ZEND_DB_DOCUMENT_ADAPTER_MONGO_PORT,
            'dbname' => TESTS_ZEND_DB_DOCUMENT_ADAPTER_MONGO_DATABASE,
        ));
        $this->assertRegExp('/^[a-f0-9]{24}$/', $adapter->getCollection(TESTS_ZEND_DB_DOCUMENT_ADAPTER_MONGO_COLLECTION)
            ->post(array('nane'=>'peter')));
    }

    public function testGet()
    {
        $adapter = new DbDocument\Adapter\Mongo(array(
            'host' => TESTS_ZEND_DB_DOCUMENT_ADAPTER_MONGO_HOST,
            'port' => TESTS_ZEND_DB_DOCUMENT_ADAPTER_MONGO_PORT,
            'dbname' => TESTS_ZEND_DB_DOCUMENT_ADAPTER_MONGO_DATABASE,
        ));
        $name = $adapter->getCollection(TESTS_ZEND_DB_DOCUMENT_ADAPTER_MONGO_COLLECTION)
            ->post(array('name'=>'peter'));
        $this->assertEquals($adapter->getCollection(TESTS_ZEND_DB_DOCUMENT_ADAPTER_MONGO_COLLECTION)
            ->get($name), array('_id'=>new \MongoId($name), 'name'=>'peter'));
    }

    public function testDelete()
    {
        $adapter = new DbDocument\Adapter\Mongo(array(
            'host' => TESTS_ZEND_DB_DOCUMENT_ADAPTER_MONGO_HOST,
            'port' => TESTS_ZEND_DB_DOCUMENT_ADAPTER_MONGO_PORT,
            'dbname' => TESTS_ZEND_DB_DOCUMENT_ADAPTER_MONGO_DATABASE,
        ));
        $name = $adapter->getCollection(TESTS_ZEND_DB_DOCUMENT_ADAPTER_MONGO_COLLECTION)
            ->post(array('name'=>'peter'));
        $adapter->getCollection(TESTS_ZEND_DB_DOCUMENT_ADAPTER_MONGO_COLLECTION)
            ->delete($name);
        $this->assertNull($adapter->getCollection(TESTS_ZEND_DB_DOCUMENT_ADAPTER_MONGO_COLLECTION)
            ->get($name));
    }

}

