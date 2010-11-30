<?php
namespace Test;

use Zend\Db\Document as DbDocument;

class RedisTest extends \PHPUnit_Framework_TestCase
{
    private function _getCollection()
    {
        $adapter = new DbDocument\Adapter\Redis(array(
            'host' => TESTS_ZEND_DB_DOCUMENT_ADAPTER_REDIS_HOST,
            'port' => TESTS_ZEND_DB_DOCUMENT_ADAPTER_REDIS_PORT,
        ));
        return $adapter->getCollection(TESTS_ZEND_DB_DOCUMENT_ADAPTER_REDIS_COLLECTION);
    }

    public function setUp()
    {
        if (!defined('TESTS_ZEND_DB_DOCUMENT_ADAPTER_REDIS_ENABLED') || !TESTS_ZEND_DB_DOCUMENT_ADAPTER_REDIS_ENABLED) {
            $this->markTestSkipped('The Redis extension is not available.');
        }
    }

    public function testInit()
    {
        $adapter = new DbDocument\Adapter\Redis(array(
            'host' => TESTS_ZEND_DB_DOCUMENT_ADAPTER_REDIS_HOST,
            'port' => TESTS_ZEND_DB_DOCUMENT_ADAPTER_REDIS_PORT,
        ));
    }

    public function testGetConnection()
    {
        $adapter = new DbDocument\Adapter\Redis(array(
            'host' => TESTS_ZEND_DB_DOCUMENT_ADAPTER_REDIS_HOST,
            'port' => TESTS_ZEND_DB_DOCUMENT_ADAPTER_REDIS_PORT,
        ));
        $this->assertType('resource', $adapter->getConnection());
    }

    public function testGetCollection()
    {
        $adapter = new DbDocument\Adapter\Redis(array(
            'host' => TESTS_ZEND_DB_DOCUMENT_ADAPTER_REDIS_HOST,
            'port' => TESTS_ZEND_DB_DOCUMENT_ADAPTER_REDIS_PORT,
        ));
        $this->assertType('Zend\\Db\\Document\\Collection\\Redis', $adapter->getCollection(TESTS_ZEND_DB_DOCUMENT_ADAPTER_REDIS_COLLECTION));
    }

    public function testPut()
    {
        $this->assertTrue($this->_getCollection()->put('test', array('nane'=>'peter')));
    }

    public function testGet()
    {
        $this->_getCollection()->put('test', array('name'=>'peter'));
        $document = $this->_getCollection()->get('test');
        $this->assertType('Zend\\Db\\Document\\Document\\Redis', $document);
        $this->assertEquals($document->getId(), 'test');
        $this->assertEquals($document->toArray(), array('name'=>'peter'));
    }

    public function testPost()
    {
        try {
            $this->_getCollection()->post(array('nane'=>'peter'));
        } catch (\Exception $e) {
            return ;
        }
        $this->fail('Expect exception');
    }

    public function testDelete()
    {
        $this->_getCollection()->put('test', array('name'=>'peter'));
        $this->_getCollection()->delete('test');
        $this->assertNull($this->_getCollection()->get('test'));
    }
}

