<?php
namespace Zend\Db\Document\Adapter;

use Zend\Db\Document as DbDocument;

class Riak extends DbDocument\AbstractAdapter
{
    const PRIMARY = '_id';
    const ETAG    = '_etag';
    const DATA    = '_data';

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

    public function findOne($collectionName, $query, array $fields=array())
    {
        $this->_connect();
        $request = $this->_buildRequest($collectionName, $query, $fields);
        $response = $this->_connection->restPost('/mapred', \Zend\Json\Encoder::encode($request));
        if ($response->isError()) return null;
        $items = \Zend\Json\Decoder::decode($response->getBody());
        $item = array_shift($items);
        $document = new DbDocument\Document\Riak($this->getCollection($collectionName), $item[self::DATA]);
        $document->setId($item[self::PRIMARY]);
        return $document;
    }

    public function find($collectionName, $query, array $fields=array())
    {
        $this->_connect();
        $request = $this->_buildRequest($collectionName, $query, $fields);
        $response = $this->_connection->restPost('/mapred', \Zend\Json\Encoder::encode($request));
        if ($response->isError()) return null;
        return new DbDocument\Cursor\Riak($this->getCollection($collectionName), \Zend\Json\Decoder::decode($response->getBody()));
    }

    private function _buildRequest($collectionName, array $query, array $fields=array())
    {
        $request = array(
            'inputs' => $collectionName,
            'query' => array(
                array(
                    'map' => array(
                        'language' => 'javascript',
                        'source'   => 'function(v) { var keys = Riak.mapValuesJson(v)[0]; return [{' . self::PRIMARY . ': v.key, ' . self::DATA . ': keys}]; }',
                        'keep'     => true,
                    )
                )
            )
        );
        if (empty($query)) return $request;
        $where = array();
        foreach ($query as $name=>$value) {
            $where[] = $name . '="' . addslashes($value) . '"';
        }
        $request['query'][0]['map']['source'] = 'function(v){ var keys = Riak.mapValuesJson(v)[0]; if(' . join('&&', $where) . ') {return [{' . self::PRIMARY . ': v.key, ' . self::DATA . ': keys}];} else { return []; } }';
        return $request;
    }
}

