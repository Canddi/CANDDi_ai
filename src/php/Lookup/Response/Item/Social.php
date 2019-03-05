<?php
/**
 * Wrapper for CANDDi Lookup
 * https://api.canddi.net
 *
 * @TODO REFACTOR THIS TO a separate composer package
 *
 * @author Christian Wilkinson
 **/

namespace CanddiAi\Lookup\Response\Item;

use CanddiAi\Traits\GetArrayValue as NS_traitArrayValue;

class Social
{
    const KEY_TYPE      = 'typeId';
    const KEY_URL       = 'url';
    const KEY_USERNAME  = 'username';

    use NS_traitArrayValue;

    private $_arrResponse;

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
