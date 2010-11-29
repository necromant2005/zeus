<?php
namespace Test;

use Zend\Db\Document as DbDocument;

class CollectionMock implements DbDocument\Collection
{
    public function __construct(DbDocument\AbstractAdapter $adapter, $name){}

    public function get($name){}

    public function put($name, array $data){}

    public function post(array $data){}

    public function delete($name){}

    public function findOne(){}

    public function findAll(){}
}

