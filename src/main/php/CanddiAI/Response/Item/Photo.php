<?php
/**
 * @author Christian Wilkinson
 **/

namespace CanddiAI\Response\Item;

class Photo extends \CanddiAI\Response\LookupAbstract
{
    const KEY_PRIMARY   = 'IsPrimary';
    const KEY_NAME      = 'Name';
    const KEY_URL       = 'URL';

    use NS_traitArrayValue;

    protected $_arrResponse;

    public function __construct(Array $arrResponse)
    {
        $this->_arrResponse = $arrResponse;
    }
    public function bPrimary()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_PRIMARY
            ],
            false
        );
    }
    public function getName()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_NAME
            ],
            ""
        );
    }
    public function getURL()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_URL
            ],
            ""
        );
    }
}
