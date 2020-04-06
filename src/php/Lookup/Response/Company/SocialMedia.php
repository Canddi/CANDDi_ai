<?php

namespace CanddiAi\Lookup\Response\Company;

use CanddiAi\Traits\GetArrayValue as NS_traitArrayValue;

class SocialMedia
{
    const KEY_URL = "url";
    const KEY_PLATFORM = "platform";
    const KEY_HANDLE = "handle";

    use NS_traitArrayValue;

    private $_arrResponse;

    public function __construct(Array $arrResponse)
    {
        $this->_arrResponse = $arrResponse;
    }

    public function getUrl()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_URL],
            null
        );
    }
    public function getPlatform()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_PLATFORM],
            null
        );
    }
    public function getHandle()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_HANDLE],
            null
        );
    }
}
