<?php
/**
 * @author Christian Wilkinson
 **/

namespace CanddiAI\Response\Item;

class Social extends \CanddiAI\Response\LookupAbstract
{
    const KEY_TYPE      = 'typeId';
    const KEY_URL       = 'url';
    const KEY_USERNAME  = 'username';

    protected $_arrResponse;

    public function __construct(Array $arrResponse)
    {
        $this->_arrResponse = $arrResponse;
    }
    public function getType()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_TYPE
            ],
            false
        );
    }
    public function getURL()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_URL
            ],
            null
        );
    }
    public function getUsername()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_USERNAME
            ],
            false
        );
    }
}
