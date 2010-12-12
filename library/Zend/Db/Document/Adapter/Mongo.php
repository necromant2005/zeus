<?php
namespace Zend\Db\Document\Adapter;

use Zend\Db\Document as DbDocument;

class Mongo extends DbDocument\AbstractAdapter
{
    const PRIMARY = '_id';

    protected $_dbname = '';

    public function _connect()
    {
        if ($this->isConnected()) return;
        $this->_connection = new \Mongo("mongodb://" . $this->_options['host'] . ':' . $this->_options['port'], array("connect" => true));
        $this->setDbName($this->_options['dbname']);
    }

    public function getCollection($name)
    {
        return new DbDocument\Collection\Mongo($this, $name);
    }

    public function setDbName($name)
    {
        return $this->_dbname = $name;
    }

    public function getDbName()
    {
        return $this->_options['dbname'];
    }

    public function post($collectionName, array $data)
    {
        $this->_connect();
        $this->_connection->selectDB($this->getDbName())->selectCollection($collectionName)->insert($data);
        return (string)$data[self::PRIMARY];
    }

    public function put($collectionName, $name, array $data)
    {
        throw new \Exception('Put not supports for ' . get_class($this));
    }

    public function get($collectionName, $name)
    {
        return $this->findOne($collectionName, array(self::PRIMARY => new \MongoId($name)));
    }

    public function delete($collectionName, $name)
    {
        $this->_connect();
        return $this->_connection->selectDB($this->getDbName())->selectCollection($collectionName)->remove(array(self::PRIMARY => new \MongoId($name)));
    }

    public function findOne($collectionName, array $query, array $fields=array())
    {
        $this->_connect();
        return $this->_parseResponse($collectionName, $this->_connection->selectDB($this->getDbName())->selectCollection($collectionName)->findOne($query, $fields));
    }

    public function find($collectionName, array $query, $fields=array())
    {
        $this->_connect();
        return new DbDocument\Cursor\Mongo($this->getCollection($collectionName),
            $this->_connection->selectDB($this->getDbName())->selectCollection($collectionName)->find($query, $fields));
    }

    protected function _parseResponse($collectionName, $response)
    {
        if (is_null($response)) return null;
        return new DbDocument\Document\Mongo($this->getCollection($collectionName), $response);
    }
}

