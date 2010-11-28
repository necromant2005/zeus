<?php
namespace Test;

require_once __DIR__ . '/../../../../../library/Zend/Db/Document/AbstractAdapter.php';
require_once __DIR__ . '/../../../../../library/Zend/Db/Document/Adapter/Redis.php';

use Zend\Db\Document as DbDocument;

class RedisTest extends \PHPUnit_Framework_TestCase
{
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
}

