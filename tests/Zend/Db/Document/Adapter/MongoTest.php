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
}

