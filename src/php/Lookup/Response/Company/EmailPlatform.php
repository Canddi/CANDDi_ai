<?php

namespace CanddiAi\Lookup\Response\Company;

use CanddiAi\Traits\GetArrayValue as NS_traitArrayValue;

class EmailPlatform
{
    const KEY_MX        = 'MX';
    const KEY_PRIORITY  = 'Priority';
    const KEY_TYPE      = 'Type';

    use NS_traitArrayValue;

    private $_arrResponse;

    public function __construct(Array $arrResponse)
    {
        $this->_arrResponse = $arrResponse;
    }

    public function getMX()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_MX],
            null
        );
    }
    public function getPriority()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_PRIORITY],
            null
        );
    }
    public function getType()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_TYPE],
            null
        );
    }
}
