<?php
namespace Zend\Db\Document\Cursor;

use Zend\Db\Document as DbDocument;

class Couch extends DbDocument\AbstractCursor
{
    const OFFSET = 'offset';
    const ROWS   = 'rows';
    const TOTAL  = 'total_rows';
    const VALUE  = 'value';

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
        $item = $this->_rowset[self::ROWS][$this->_pointer];
        return new DbDocument\Document\Couch($this->_collection, $item[self::VALUE]);
    }

    public function valid()
    {
        return $this->_pointer>=$this->count();
    }

    public function count()
    {
        return count($this->_rowset[self::ROWS]);
    }
}

