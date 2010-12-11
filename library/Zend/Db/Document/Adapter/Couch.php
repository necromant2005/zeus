<?php
namespace Zend\Db\Document\Adapter;

use Zend\Db\Document as DbDocument;

class Couch extends DbDocument\AbstractAdapter
{
    const PRIMARY = '_id';
    const REVISION = '_rev';

    const PARSE_PRIMARY = 'id';
    const PARSE_REVISION = 'rev';
    const PARSE_REASON = 'reason';
    const PARSE_ERROR = 'error';

    protected $_dbName = '';

    protected function _connect()
    {
        if ($this->isConnected()) return;
        $this->_connection = new \Zend\Rest\Client\RestClient('http://'
            . $this->_options['host'] . ':' . $this->_options['port']);
        $this->_dbName = $this->_options['dbname'];
    }

    protected function _generatePath($name='', $revision='')
    {
        if ($name) {
            if ($revision) {
                return $this->_dbName . '/' . $name . '?' . self::PARSE_REVISION . '=' . $revision;
            } else {
                return $this->_dbName . '/' . $name;
            }
        }
        return $this->_dbName;
    }

    protected function _parseResponse(\Zend\Http\Response $response)
    {
        $body = \Zend\Json\Decoder::decode($response->getBody());
        if (array_key_exists(self::PARSE_ERROR, $body)) {
            throw new \Exception($body[self::PARSE_REASON]);
        }
        return $body;
    }

    public function getCollection($name)
    {
        return new DbDocument\Collection\Couch($this, $name);
    }

    public function post($collectionName, array $data)
    {
        $this->_connect();
        $response = $this->_connection->restPost($this->_generatePath(), \Zend\Json\Encoder::encode($data));
        $parsed = $this->_parseResponse($response);
        return $parsed[self::PARSE_PRIMARY];
    }

    public function put($collectionName, $name, array $data)
    {
        $this->_connect();
        $response = $this->_connection->restPut($this->_generatePath($name), \Zend\Json\Encoder::encode($data));
        $this->_parseResponse($response);
        return true;
    }

    public function get($collectionName, $name)
    {
        $this->_connect();
        $response = $this->_connection->restGet($this->_generatePath($name));
        try {
            return new DbDocument\Document\Couch($this->getCollection($collectionName), $this->_parseResponse($response));
        } catch (\Exception $e) {
            return null;
        }
    }

    public function delete($collectionName, $name)
    {
        $this->_connect();
        $document = $this->get($collectionName, $name);
        if (!$document) return false;
        $response = $this->_connection->restDelete($this->_generatePath($name, $document->getRevision()));
        $this->_parseResponse($response);
        return true;
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

