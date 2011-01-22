<?php
namespace Test;

use Zend\Db\Document as DbDocument;

class AbstractQueryMock extends DbDocument\AbstractQuery
{
    public function where($name, $value)
    {
        $this->_query[] = $name . '="' . $value . '"';
        return $this;
    }

    public function whereLess($name, $value)
    {
        $this->_query[] = $name . '<' . $value;
        return $this;
    }

    public function whereMore($name, $value)
    {
        $this->_query[] = $name . '>' . $value;
        return $this;
    }

    public function whereIn($name, array $value)
    {
        $query = array();
        foreach ($value as $item) {
            $query[] = $name . '="' . $item . '"';
        }
        $this->_query[] = '(' . join('||', $query) . ')';
        return $this;
    }
}

