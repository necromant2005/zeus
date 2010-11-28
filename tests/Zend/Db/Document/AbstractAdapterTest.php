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
        $this->assertFalse($adapter->isConnected());
    }

    public function testLazyLoadConnected()
    {
        $adapter = new AbstractAdapterMock(array());
        $adapter->_connect();
        $this->assertTrue($adapter->isConnected());
    }

    public function testLazyLoadWhenGetConnectionCalls()
    {
        $adapter = new AbstractAdapterMock(array());
        $adapter->getConnection();
        $this->assertTrue($adapter->isConnected());
    }

    public function testSetConnection()
    {
        $adapter = new AbstractAdapterMock(array());
        $adapter->setConnection('test value');
        $this->assertEquals($adapter->getConnection(), 'test value');
    }

    public function testGetCollection()
    {
        $adapter = new AbstractAdapterMock(array());
        $this->assertType('Zend\\Db\\Document\\Collection', $adapter->getCollection('test'));
    }
}

