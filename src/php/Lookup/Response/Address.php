<?php

namespace CanddiAi\Lookup\Response;

use CanddiAi\Traits\GetArrayValue as NS_traitArrayValue;

class Address
{
    const KEY_CITY              = 'City';
    const KEY_COUNTRY           = 'Country';
    const KEY_LINE1             = 'Line1';
    const KEY_LINE2             = 'Line2';
    const KEY_FORMATTED_ADDRESS = 'FormattedAddress';
    const KEY_POSTALCODE        = 'PostalCode';
    const KEY_LAT               = "Lat";
    const KEY_LNG               = "Lng";


    use NS_traitArrayValue;

    private $_arrResponse;

    public function __construct(Array $arrResponse)
    {
        $this->_arrResponse = $arrResponse;
    }
    public function getCity()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_CITY
            ],
            ""
        );
    }
    public function getCountry()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_COUNTRY
            ],
            ""
        );
    }
    public function getLine1()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_LINE1
            ],
            ""
        );
    }
    public function getLine2()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_LINE2
            ],
            ""
        );
    }
    public function getFormattedAddress()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_FORMATTED_ADDRESS
            ],
            ""
        );
    }
    public function getPostalCode()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_POSTALCODE
            ],
            ""
        );
    }
    public function getLat()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_LAT
            ],
            ""
        );
    }
    public function getLng()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_LNG
            ],
            ""
        );
    }
}
