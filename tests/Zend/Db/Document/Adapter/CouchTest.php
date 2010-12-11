<?php
namespace Test;

use Zend\Db\Document as DbDocument;

class CouchTest extends \PHPUnit_Framework_TestCase
{
    private function _getCollection()
    {
        $adapter = new DbDocument\Adapter\Couch(array(
            'host' => TESTS_ZEND_DB_DOCUMENT_ADAPTER_COUCH_HOST,
            'port' => TESTS_ZEND_DB_DOCUMENT_ADAPTER_COUCH_PORT,
            'dbname' => TESTS_ZEND_DB_DOCUMENT_ADAPTER_COUCH_DATABASE,
        ));
        return $adapter->getCollection(TESTS_ZEND_DB_DOCUMENT_ADAPTER_COUCH_COLLECTION);
    }


    public function setUp()
    {
        if (!defined('TESTS_ZEND_DB_DOCUMENT_ADAPTER_COUCH_ENABLED') || !TESTS_ZEND_DB_DOCUMENT_ADAPTER_COUCH_ENABLED) {
            $this->markTestSkipped('The CouchDb extension is not available.');
        }
    }

    public function testInit()
    {
        $adapter = new DbDocument\Adapter\Couch();
    }

    public function testGetConnection()
    {
        $adapter = new DbDocument\Adapter\Couch(array(
            'host' => TESTS_ZEND_DB_DOCUMENT_ADAPTER_COUCH_HOST,
            'port' => TESTS_ZEND_DB_DOCUMENT_ADAPTER_COUCH_PORT,
            'dbname' => TESTS_ZEND_DB_DOCUMENT_ADAPTER_COUCH_DATABASE,
        ));
        $this->assertType('Zend\\Rest\\Client\\RestClient', $adapter->getConnection());
    }

    public function testGetCollection()
    {
        $adapter = new DbDocument\Adapter\Couch(array(
            'host' => TESTS_ZEND_DB_DOCUMENT_ADAPTER_COUCH_HOST,
            'port' => TESTS_ZEND_DB_DOCUMENT_ADAPTER_COUCH_PORT,
            'dbname' => TESTS_ZEND_DB_DOCUMENT_ADAPTER_COUCH_DATABASE,
        ));
        $this->assertType('Zend\\Db\\Document\\Collection\\Couch', $adapter->getCollection(TESTS_ZEND_DB_DOCUMENT_ADAPTER_COUCH_COLLECTION));
    }

    public function testPut()
    {
        $this->_getCollection()->delete('test');
        $this->_getCollection()->put('test', array('name'=>'peter'));
        $this->assertEquals($this->_getCollection()->get('test')->toArray(), array('name'=>'peter'));
    }

    public function testPost()
    {
        $this->assertRegExp('/^[a-f0-9]{32}$/', $this->_getCollection()->post(array('nane'=>'peter')));
    }

    public function testGet()
    {
        $name = $this->_getCollection()->post(array('name'=>'peter'));
        $document = $this->_getCollection()->get($name);
        $this->assertType('Zend\\Db\\Document\\Document\\Couch', $document);
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

