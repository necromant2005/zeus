<?php
namespace Zend\Db\Document\Document;

use Zend\Db\Document as DbDocument;

class Riak extends DbDocument\AbstractDocument
{
    protected $_etag = '';

    protected $_mapPrimaryFields = array(
        DbDocument\Adapter\Riak::PRIMARY => 'setId',
        DbDocument\Adapter\Riak::ETAG => 'setEtag',
    );

    public function setEtag($etag)
    {
        $this->_etag = $etag;
    }

    public function getEtag()
    {
        return $this->_etag;
    }
}

