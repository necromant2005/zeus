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
        $this->_connect();
        $value = serialize($data);
        $this->_write('RPUSH' . " $collectionName " . strlen($value) . "\r\n$value\r\n");
        return $this->_read();
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
        $document = new DbDocument\Document\Redis($this->getCollection($collectionName),
            $this->_call("GET $name\r\n"));
        return $document->setId($name);
    }

    public function delete($collectionName, $name)
    {
        $this->_connect();
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
        return $this->_parse($this->_read());
    }

    protected function _write($data)
    {
        $this->_connect();
        fwrite($this->_connection, $data);
    }

    protected function _read()
    {
        $this->_connect();
        $buffer = '';
        while (!feof($this->_connection)) {
            $byte = fread($this->_connection, 1);
            $buffer .= $byte;
            if ($byte=="\n") break;
        }
        return $buffer;
    }

    public function _parse($response)
    {
        switch (substr($response, 0, 1)) {
            case '-':
                return false;
            case '+':
                return true;
            case '$':
                if ($response=='$-1') return null;
                $bytes = (int)substr($response, 1);
                return unserialize(substr($this->_read(), 0, $bytes));
            case ':':
                throw new \Exception(': ' . $response);
                $i = strpos($data, '.') !== false ? (int)$data : (float)$data;
                if ((string)$i != $data)
                    trigger_error("Cannot convert data '$c$data' to integer", E_USER_ERROR);
                return $i;
            case '*':
                throw new \Exception('* ' . $response);
                $num = (int)$data;
                if ((string)$num != $data)
                    trigger_error("Cannot convert multi-response header '$data' to integer", E_USER_ERROR);
                $result = array();
                for ($i=0; $i<$num; $i++)
                    $result[] =& $this->get_response();
                return $result;
            default:
                throw new \Exception('Unknow ' . $response);
                trigger_error("Invalid reply type byte: '$c'");
        }
    }
}

