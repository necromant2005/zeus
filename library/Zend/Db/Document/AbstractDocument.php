<?php
namespace Zend\Db\Document;

abstract class AbstractDocument
{
    protected $_data = array();

    protected $_id = '';

    protected $_mapPrimaryFields = array();

    protected $_collection = null;

    public function __construct(AbstractCollection $collection, array $data)
    {
        $this->_collection = $collection;
        $this->setFromArray($data);
    }

    public function setId($id)
    {
        $this->_id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function __get($name)
    {
        if (!$this->__isset($name)) throw new \Exception('Property '.$name.' doesn\'t exist');
        return $this->_data[$name];
    }

    public function __set($name, $value)
    {
        if (array_key_exists($name, $this->_mapPrimaryFields)) {
            return $this->setPrimary($name, $value);
        }
        return $this->_data[$name] = $value;
    }

    public function __isset($name)
    {
        return array_key_exists($name, $this->_data);
    }

    public function toArray()
    {
        return $this->_data;
    }

    public function setFromArray($data)
    {
        foreach ($data as $name=>$value) {
            $this->{$name} = $value;
        }
        return $this;
    }

    public function setPrimary($name, $value)
    {
        $methodName = $this->_mapPrimaryFields[$name];
        return $this->{$methodName}($value);
    }
}

