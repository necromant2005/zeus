<?php
namespace Zend\Db\Document;

abstract class AbstractQuery
{
    protected $_collection = null;

    public function __construct(AbstractCollection $collection)
    {
        $this->_collection = $collection;
    }

}

