<?php
namespace Zend\Db\Document\Document;

use Zend\Db\Document as DbDocument;

class Couch extends DbDocument\AbstractDocument
{
    protected $_revision = 0;

    protected $_mapPrimaryFields = array(
        DbDocument\Adapter\Couch::PRIMARY => 'setId',
        DbDocument\Adapter\Couch::REVISION => 'setRevision',
    );

    public function setRevision($revision)
    {
        $this->_revision = $revision;
    }

    public function getRevision()
    {
        return $this->_revision;
    }
}

