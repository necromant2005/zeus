<?php
namespace Zend\Db\Document\Cursor;

use Zend\Db\Document as DbDocument;

class Riak extends DbDocument\AbstractCursor
{
    protected $_pointer = 0;

    public function rewind()
    {
        $this->_pointer = 0;
    }

    public function next()
    {
        $this->_pointer++;
    }

    public function key()
    {
        return $this->_pointer;
    }

    public function current()
    {
        $item = $this->_rowset[$this->_pointer];
        $document = new DbDocument\Document\Riak($this->_collection, $item[DbDocument\Adapter\Riak::DATA]);
        $document->setId($item[DbDocument\Adapter\Riak::PRIMARY]);
        return $document;
    }

    public function valid()
    {
        return $this->_pointer>=$this->count();
    }

    public function count()
    {
        return count($this->_rowset);
    }
}

