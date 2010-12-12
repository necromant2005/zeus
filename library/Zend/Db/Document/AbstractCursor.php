<?php
namespace Zend\Db\Document;

abstract class AbstractCursor implements \Iterator, \Countable
{
    protected $_collection = null;

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
    {}
    public function next()
    {}
    public function key()
    {}
    public function current()
    {}
    public function valid()
    {}
    public function count()
    {}
}

