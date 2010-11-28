<?php
namespace Test;

use Zend\Db\Document as DbDocument;

class CouchTest extends \PHPUnit_Framework_TestCase
{
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
}

