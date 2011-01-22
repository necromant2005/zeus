<?php
namespace Zend\Db\Document;

abstract class AbstractQuery
{
    protected $_collection = null;

    protected $_query = array();

    protected $_map = null;

    protected $_reduce = null;

    public function __construct(AbstractCollection $collection)
    {
        $this->_collection = $collection;
    }

    public function findOne()
    {
        return $this->_collection->findOne($this);
    }

    public function find()
    {
        return $this->_collection->find($this);
    }

    public function toArray()
    {
        return $this->_query;
    }

    public function hasMapFunction()
    {
        return (bool)$this->_map;
    }

    public function hasReduceFunction()
    {
        return (bool)$this->_reduce;
    }

    public function getMapFunction()
    {
        return $this->_map;
    }

    public function getReduceFunction()
    {
        return $this->_reduce;
    }

    public function map($function)
    {
        $this->_map = $function;
        return $this;
    }

    public function reduce($function)
    {
        $this->_reduce = $function;
        return $this;
    }

    abstract public function where($name, $value);

    abstract public function whereLess($name, $value);

    abstract public function whereMore($name, $value);

    abstract public function whereIn($name, array $value);
}

