<?php
namespace Test;

require_once __DIR__ . '/_files/AbstractAdapterMock.php';

require_once __DIR__ . '/_files/AbstractCollectionMock.php';

require_once __DIR__ . '/_files/AbstractDocumentMock.php';

require_once __DIR__ . '/_files/AbstractQueryMock.php';

use Zend\Db\Document as DbDocument;

class AbstractQueryTest extends \PHPUnit_Framework_TestCase
{
    protected $_query = null;

    public function setUp()
    {
        $stub = $this->getMockForAbstractClass('\\Zend\\Db\\Document\\AbstractAdapter');
        $this->_query = new AbstractQueryMock(new AbstractCollectionMock($stub, 'test'));
    }

    public function testInit()
    {
        $stub = $this->getMockForAbstractClass('\\Zend\\Db\\Document\\AbstractAdapter');
        $query = new AbstractQueryMock(new AbstractCollectionMock($stub, 'test'));
    }

    public function testWhere()
    {
        $this->_query
            ->where('name', 'peter')
            ->whereLess('age', 90)
            ->whereMore('money', 100)
            ->whereIn('city', array('Banton', 'Morlaw', 'Danver'));
        $this->assertEquals($this->_query->toArray(), array(
            'name="peter"',
            'age<90',
            'money>100',
            '(city="Banton"||city="Morlaw"||city="Danver")'
        ));
    }

    public function testToArray()
    {
        $this->assertEquals($this->_query->toArray(), array());
    }

    public function testHasMapFunction()
    {
        $this->assertFalse($this->_query->hasMapFunction());
    }

    public function testMapFunction()
    {
        $this->_query->map('123');
        $this->assertTrue($this->_query->hasMapFunction());
        $this->assertEquals($this->_query->getMapFunction(), '123');
    }

    public function testHasReduceFunction()
    {
        $this->assertFalse($this->_query->hasReduceFunction());
    }

    public function testReduceFunction()
    {
        $this->_query->reduce('1234');
        $this->assertTrue($this->_query->hasReduceFunction());
        $this->assertEquals($this->_query->getReduceFunction(), '1234');
    }

    public function testFind()
    {
        $query = new AbstractQueryMock(new AbstractCollectionMock(new AbstractAdapterMock, 'test'));
        $query->find();
    }
}

