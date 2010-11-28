<?php
namespace Test;

use Zend\Db\Document as DbDocument;

require_once __DIR__ . '/../../../../../library/Zend/Db/Document/AbstractAdapter.php';
require_once __DIR__ . '/../../../../../library/Zend/Db/Document/Adapter/Mongo.php';


class MongoTest extends \PHPUnit_Framework_TestCase
{
    public function testConnection()
    {
        $adapter = new DbDocument\Adapter\Mongo();
    }
}

