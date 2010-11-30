<?php
namespace Test;

use Zend\Db\Document as DbDocument;

class AbstractDocumentMock extends DbDocument\AbstractDocument
{
    protected $_mapPrimaryFields = array('_id'=>'setId');
}

