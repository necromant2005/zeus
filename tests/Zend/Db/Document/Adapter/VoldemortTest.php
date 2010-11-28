<?php
namespace Test;

use Zend\Db\Document as DbDocument;

class VoldemortTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        if (!defined('TESTS_ZEND_DB_DOCUMENT_ADAPTER_VOLDEMORT_ENABLED') || !TESTS_ZEND_DB_DOCUMENT_ADAPTER_VOLDEMORT_ENABLED) {
            $this->markTestSkipped('The Voldemort extension is not available.');
        }
    }

    public function testInit()
    {
        $adapter = new DbDocument\Adapter\Voldemort(array(
            'host' => TESTS_ZEND_DB_DOCUMENT_ADAPTER_VOLDEMORT_HOST,
            'port' => TESTS_ZEND_DB_DOCUMENT_ADAPTER_VOLDEMORT_PORT,
        ));
    }

    public function testGetConnection()
    {
        $adapter = new DbDocument\Adapter\Voldemort(array(
            'host' => TESTS_ZEND_DB_DOCUMENT_ADAPTER_VOLDEMORT_HOST,
            'port' => TESTS_ZEND_DB_DOCUMENT_ADAPTER_VOLDEMORT_PORT,
        ));
        $this->assertType('resource', $adapter->getConnection());
    }
}

