<?php
namespace Test;

use Zend\Db\Document as DbDocument;

class RiakTest extends \PHPUnit_Framework_TestCase
{
    private function _getCollection()
    {
        $adapter = new DbDocument\Adapter\Riak(array(
            'host' => TESTS_ZEND_DB_DOCUMENT_ADAPTER_RIAK_HOST,
            'port' => TESTS_ZEND_DB_DOCUMENT_ADAPTER_RIAK_PORT,
        ));
        return $adapter->getCollection(TESTS_ZEND_DB_DOCUMENT_ADAPTER_RIAK_COLLECTION);
    }

    public function setUp()
    {
        if (!defined('TESTS_ZEND_DB_DOCUMENT_ADAPTER_RIAK_ENABLED') || !TESTS_ZEND_DB_DOCUMENT_ADAPTER_RIAK_ENABLED) {
            $this->markTestSkipped('The Riak extension is not available.');
        }
    }

    public function testInit()
    {
        $adapter = new DbDocument\Adapter\Couch();
    }

    public function testGetConnection()
    {
        $adapter = new DbDocument\Adapter\Riak(array(
            'host' => TESTS_ZEND_DB_DOCUMENT_ADAPTER_RIAK_HOST,
            'port' => TESTS_ZEND_DB_DOCUMENT_ADAPTER_RIAK_PORT,
        ));
        $this->assertType('Zend\\Rest\\Client\\RestClient', $adapter->getConnection());
    }

    public function testGetCollection()
    {
        $adapter = new DbDocument\Adapter\Riak(array(
            'host' => TESTS_ZEND_DB_DOCUMENT_ADAPTER_RIAK_HOST,
            'port' => TESTS_ZEND_DB_DOCUMENT_ADAPTER_RIAK_PORT,
        ));
        $this->assertType('Zend\\Db\\Document\\Collection\\Riak', $adapter->getCollection(TESTS_ZEND_DB_DOCUMENT_ADAPTER_RIAK_COLLECTION));
    }

    public function testPut()
    {
        $this->assertTrue($this->_getCollection()->put('test', array('name'=>'peter')));
        $this->assertEquals($this->_getCollection()->get('test')->toArray(), array('name'=>'peter'));
    }

    public function testPost()
    {
        $this->assertRegExp('/^[a-zA-Z0-9]{27}$/', $this->_getCollection()->post(array('nane'=>'peter')));
    }

    public function testGet()
    {
        $name = $this->_getCollection()->post(array('name'=>'peter'));
        $document = $this->_getCollection()->get($name);
        $this->assertType('Zend\\Db\\Document\\Document\\Riak', $document);
        $this->assertEquals($document->getId(), $name);
        $this->assertEquals($document->toArray(), array('name'=>'peter'));
    }

    public function testGetNoExists()
    {
        $document = $this->_getCollection()->get('some-non-exists');
        $this->assertNull($document);
    }

    public function testDelete()
    {
        $name = $this->_getCollection()->post(array('name'=>'peter'));
        $this->assertTrue($this->_getCollection()->delete($name));
        $this->assertNull($this->_getCollection()->get($name));
    }
}

