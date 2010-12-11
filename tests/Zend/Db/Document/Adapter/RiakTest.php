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
}

