<?php
namespace Zend\Db\Document\Adapter;

use Zend\Db\Document as DbDocument;

class Redis extends DbDocument\AbstractAdapter
{
    const CONNECTION_TIMEOUT = 1;
    const STREAM_TIMEOUT = 1;

    protected function _connect()
    {
        if ($this->isConnected()) return;
        $this->_connection = stream_socket_client('tcp://' . $this->_options['host'] . ':' . $this->_options['port'],
            $errno, $errstr, self::CONNECTION_TIMEOUT);
        if (!is_resource($this->_connection)) {
            throw new \Exception($errstr, $errno);
        }
        stream_set_blocking($this->_connection, false);
        stream_set_timeout($this->_connection, 0, self::STREAM_TIMEOUT);
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
        if (!$response) return null;
        $document = new DbDocument\Document\Redis($this->getCollection($collectionName), $response);
        return $document->setId($name);
    }

    public function delete($collectionName, $name)
    {
        $this->_call("DEL $name\r\n");
    }

    public function findOne($collectionName, array $query)
    {
        throw new \Exception('FindOne not supports for ' . get_class($this));
    }

    public function find($collectionName, array $query)
    {
        throw new \Exception('Find not supports for ' . get_class($this));
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
        if (!fwrite($this->_connection, $data)) throw new Exception('Writing data is failed');
    }

    protected function _read($length)
    {
        $this->_connect();
        $buffer = fread($this->_connection, $length);
        return $buffer;
    }

    protected function _readLine($length=100)
    {
        $read  = array($this->_connection);
        $write = null;
        $except = null;
        stream_select($read, $write, $except, 0);
        return $buffer = stream_get_line($this->_connection, 100, "\r\n");
    }

    public function _parse()
    {
        switch ($this->_read(1)) {
            case '-':
                return false;
            case '+':
                return true;
            case '$':
                $count = (int)$this->_readLine();
                $buffer = fread($this->_connection, $count+2);
                return unserialize($buffer);
            case ':':
                return $this->_readLine();
            case '*':
                throw new \Exception('* - is unknow result');
            default:
                throw new \Exception('Unknow result');
        }
    }
}

