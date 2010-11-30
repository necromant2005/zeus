<?php
namespace Zend\Db\Document\Adapter;

use Zend\Db\Document as DbDocument;

class Redis extends DbDocument\AbstractAdapter
{
    protected function _connect()
    {
        if ($this->isConnected()) return;
        $this->_connection = fsockopen($this->_options['host'], $this->_options['port'], $errno, $errstr);
        if (!is_resource($this->_connection)) {
            throw new \Exception($errstr, $errno);
        }
        stream_set_blocking($this->_connection, true);
    }

    public function getCollection($name)
    {
        return new DbDocument\Collection\Redis($this, $name);
    }

    public function post($collectionName, array $data)
    {
        throw new \Exception('Post not supports for ' . get_class($this));
    }

    public function put($collectionName, $name, array $data)
    {
        $value = (is_array($data)) ? serialize($data) : $data;
        $lengthName = strlen($name);
        $lengthValue = strlen($value);
        return $this->_call("*3\r\n\$3\r\nSET\r\n\$$lengthName\r\n$name\r\n\$$lengthValue\r\n$value\r\n");
    }

    public function get($collectionName, $name)
    {
        $response = $this->_call("GET $name\r\n");
        if (is_null($response)) return null;
        $document = new DbDocument\Document\Redis($this->getCollection($collectionName), $response);
        return $document->setId($name);
    }

    public function delete($collectionName, $name)
    {
        $this->_call("DEL $name\r\n");
    }

    public function findOne($collectionName, array $query)
    {
        $this->_connect();
    }

    public function find($collectionName, array $query)
    {
        $this->_connect();
    }

    protected function _call($request)
    {
        $this->_connect();
        $this->_write($request);
        return $this->_parse();
    }

    protected function _write($data)
    {
        $this->_connect();
        fwrite($this->_connection, $data);
    }

    protected function _read($length)
    {
        $this->_connect();
        $buffer = fread($this->_connection, $length);
        return $buffer;
    }

    protected function _readWhile()
    {
        $buffer = '';
        do {
            $byte = $this->_read(1);
            $buffer .= $byte;
        } while (!in_array($byte, array("\n", "\r")));
        $buffer = substr($buffer, 0, -1);
        return $buffer;
    }

    public function _parse()
    {
        switch ($this->_read(1)) {
            case '-':
                return false;
            case '+':
                return true;
            case '$':
                $buffer = $this->_read(2);
                if ($buffer=='-1') return null;
                $buffer .= $this->_readWhile();
                $this->_read(1);
                return unserialize($this->_read((int)$buffer));
            case ':':
                return (int)$this->_readWhile();
            case '*':
                throw new \Exception('* ');
            default:
                throw new \Exception('Unknow result');
        }
    }
}

