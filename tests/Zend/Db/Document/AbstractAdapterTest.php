<?php
namespace Test;

require_once __DIR__ . '/_files/AbstractAdapterMock.php';

class AbstractAdapterTest extends \PHPUnit_Framework_TestCase
{
    public function testInit()
    {
        $adapter = new AbstractAdapterMock(array(
            'host' => '127.0.0.1',
            'port' => 27000,
            'dbname' => 'test'
        ));
    }

    public function testLazyLoad()
    {
        $adapter = new AbstractAdapterMock(array());
        $this->assertFalse($adapter->getConnected());
    }

    public function testLazyLoadConnected()
    {
        $adapter = new AbstractAdapterMock(array());
        $adapter->setConnection('test value');
        $this->assertTrue($adapter->getConnected());
    }

    public function testSetConnection()
    {
        $adapter = new AbstractAdapterMock(array());
        $adapter->setConnection('test value');
        $this->assertEquals($adapter->getConnection(), 'test value');
    }
}

