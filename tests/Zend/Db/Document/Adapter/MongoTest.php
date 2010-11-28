<?php
namespace Test;

use Zend\Db\Document as DbDocument;

require_once __DIR__ . '/../../../../../library/Zend/Db/Document/AbstractAdapter.php';
require_once __DIR__ . '/../../../../../library/Zend/Db/Document/Adapter/Mongo.php';


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
        $adapter = new DbDocument\Adapter\Mongo(array());
    }
}

