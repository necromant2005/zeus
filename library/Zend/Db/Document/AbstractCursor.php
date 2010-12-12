<?php
namespace Zend\Db\Document;

abstract class AbstractCursor implements \Iterator, \Countable
{
    protected $_collection = null;
    protected $_rowset     = null;

    public function __construct(AbstractCollection $collection, $rowset)
    {
        $this->_collection = $collection;
        $this->_rowset     = $rowset;
    }

    public function getAdapter()
    {
        return $this->_adapter;
    }

    public function rewind()
    {
        throw new \Exception('Should implement ' . __METHOD__);
    }

    public function next()
    {
        throw new \Exception('Should implement ' . __METHOD__);
    }

    public function key()
    {
        throw new \Exception('Should implement ' . __METHOD__);
    }

    public function current()
    {
        throw new \Exception('Should implement ' . __METHOD__);
    }

    public function valid()
    {
        throw new \Exception('Should implement ' . __METHOD__);
    }

    public function count()
    {
        throw new \Exception('Should implement ' . __METHOD__);
    }
}

