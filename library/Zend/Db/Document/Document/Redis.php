<?php
namespace Zend\Db\Document\Document;

use Zend\Db\Document as DbDocument;

class Redis extends DbDocument\AbstractDocument
{
    protected $_mapPrimaryFields = array(
        DbDocument\Adapter\Mongo::PRIMARY => 'setId'
    );
}

