<?php

namespace CanddiAi\Lookup\Response;

use CanddiAi\Traits\GetArrayValue as NS_traitArrayValue;

class UserAgent
{
    const KEY_BROWSERTYPE       = 'BrowserType';
    const KEY_BROWSERVERSION    = 'BrowserVersion';
    const KEY_OPERATINGSYSTEM   = 'OperatingSystem';
    const KEY_OPERATINGVERSION  = 'OperatingVersion';
    const KEY_DEVICE            = 'Device';
    const KEY_DEVICE_VERSION    = 'DeviceVersion';

    use NS_traitArrayValue;

    private $_arrResponse;

    public function __construct(Array $arrResponse)
    {
        $this->_arrResponse = $arrResponse;
    }
    public function getBrowserType()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_BROWSERTYPE
            ],
            ""
        );
    }
    public function getBrowserVersion()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_BROWSERVERSION
            ],
            ""
        );
    }
    public function getOperatingSystem()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_OPERATINGSYSTEM
            ],
            ""
        );
    }
    public function getOperatingVersion()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_OPERATINGVERSION
            ],
            ""
        );
    }
    public function getDevice()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_DEVICE
            ],
            ""
        );
    }
    public function getDeviceVersion()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_DEVICE_VERSION
            ],
            ""
        );
    }
}
