<?php
namespace Zend\Db\Document\Cursor;

use Zend\Db\Document as DbDocument;

class Mongo extends DbDocument\AbstractCursor
{
    public function rewind()
    {
        return $this->_rowset->rewind();
    }

    public function next()
    {
        return $this->_rowset->next();
    }

    public function key()
    {
        return $this->_rowset->key();
    }

    public function current()
    {
        $data = $this->_rowset->current();
        if (is_null($data)) return null;
        return new DbDocument\Document\Mongo($this->_collection, $data);
    }
    public function valid()
    {
        return $this->_rowset->valid();
    }

    public function count()
    {
        return count($this->rowset);
    }
}

