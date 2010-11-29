<?php
namespace Zend\Db\Document;

interface Collection
{
    public function __construct(AbstractAdapter $adapter, $name);

    public function get($name);

    public function put($name, array $data);

    public function post(array $data);

    public function delete($name);

    public function findOne();

    public function findAll();
}

