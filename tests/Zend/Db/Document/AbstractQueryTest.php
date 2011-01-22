<?php
namespace Test;

require_once __DIR__ . '/_files/AbstractCollectionMock.php';

require_once __DIR__ . '/_files/AbstractDocumentMock.php';

require_once __DIR__ . '/_files/AbstractQueryMock.php';

use Zend\Db\Document as DbDocument;

class AbstractQueryTest extends \PHPUnit_Framework_TestCase
{
    protected $_query = null;

    //public function set

    public function testInit()
    {
        $stub = $this->getMockForAbstractClass('\\Zend\\Db\\Document\\AbstractAdapter');
        $query = new AbstractQueryMock(new AbstractCollectionMock($stub, 'test'));
    }
}

