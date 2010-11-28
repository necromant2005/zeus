<?php
namespace Zend\Db\Document;

interface Collection
{
    public function __construct(AbstractAdapter $adapter, $name);

    public function get($name);

    public function put($data);

    public function post($name, $data);

    public function delete($name);

    public function findOne();

    public function findAll();
}

