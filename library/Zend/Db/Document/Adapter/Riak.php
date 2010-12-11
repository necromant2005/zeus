<?php
namespace Zend\Db\Document\Adapter;

use Zend\Db\Document as DbDocument;

class Riak extends DbDocument\AbstractAdapter
{
    const PRIMARY = '_id';
    const ETAG    = '_etag';

    protected function _connect()
    {
        if ($this->isConnected()) return;
        $this->_connection = new \Zend\Rest\Client\RestClient('http://'
            . $this->_options['host'] . ':' . $this->_options['port']);
    }

    protected function _generatePath($collectionName, $name='')
    {
        if ($name) {
            return 'riak/' . $collectionName . '/' . $name;
        }
        return 'riak/' . $collectionName;
    }

    public function getCollection($name)
    {
        return new DbDocument\Collection\Riak($this, $name);
    }

    public function post($collectionName, array $data)
    {
        $this->_connect();
        $response = $this->_connection->restPost($this->_generatePath($collectionName), \Zend\Json\Encoder::encode($data));
        $parts = explode('/', $response->getHeader('Location'));
        return array_pop($parts);
    }

    public function put($collectionName, $name, array $data)
    {
        $this->_connect();
        $response = $this->_connection->restPut($this->_generatePath($collectionName, $name), \Zend\Json\Encoder::encode($data));
        return $response->isSuccessful();
    }

    public function get($collectionName, $name)
    {
        $this->_connect();
        $response = $this->_connection->restGet($this->_generatePath($collectionName, $name));
        if ($response->isError()) return null;
        $document = new DbDocument\Document\Riak($this->getCollection($collectionName), \Zend\Json\Decoder::decode($response->getBody()));
        $document->setId($name);
        $document->setEtag($response->getHeader('Etag'));
        return $document;
    }

    public function delete($collectionName, $name)
    {
        $this->_connect();
        $response = $this->_connection->restDelete($this->_generatePath($collectionName, $name));
        return $response->isSuccessful();
    }

    public function findOne($collectionName, array $query)
    {
        $this->_connect();
    }

    public function find($collectionName, array $query)
    {
        $this->_connect();
    }
}

