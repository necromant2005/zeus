<?php
namespace Test;

use Zend\Db\Document as DbDocument;

require_once __DIR__ . '/../../../../../library/Zend/Db/Document/Collection.php';

class CollectionMock implements DbDocument\Collection
{
    public function __construct(DbDocument\AbstractAdapter $adapter, $name){}

    public function get($name){}

    public function put($data){}

    public function post($name, $data){}

    public function delete($name){}

    public function findOne(){}

    public function findAll(){}
}

