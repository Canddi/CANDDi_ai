<?php

namespace CanddiAi\Lookup\Response\Company;

use CanddiAi\Traits\GetArrayValue as NS_traitArrayValue;

class Location
{
    const KEY_CITY = "City";
    const KEY_COUNTRYCODE = "CountryCode";
    const KEY_LAT = "Lat";
    const KEY_LNG = "Lng";
    const KEY_LINE1 = "Line1";
    const KEY_LINE2 = "Line2";
    const KEY_POSTCODE = "PostCode";
    const KEY_REGION = "Region";
    const KEY_TYPE = 'LocationType';

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
            [self::KEY_CITY],
            null
        );
    }
    public function getCountryCode()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_COUNTRYCODE],
            null
        );
    }
    public function getLat()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_LAT],
            null
        );
    }
    public function getLng()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_LNG],
            null
        );
    }
    public function getLine1()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_LINE1],
            null
        );
    }
    public function getLine2()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_LINE2],
            null
        );
    }
    public function getPostCode()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_POSTCODE],
            null
        );
    }
    public function getRegion()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_REGION],
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
