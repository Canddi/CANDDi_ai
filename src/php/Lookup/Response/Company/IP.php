<?php
/**
 * Wrapper for CANDDi Lookup
 * https://api.canddi.net
 *
 * @TODO REFACTOR THIS TO a separate composer package
 *
 * @author Tim Langley
 **/
namespace CanddiAi\Lookup\Response\Company;

use CanddiAi\Traits\GetArrayValue as NS_traitArrayValue;

class IP
{
    const KEY_STARTIP = "StartIP";
    const KEY_ENDIP = "EndIP";
    const KEY_IPRANGE = "IPRange";
    const KEY_IPADDRESS = "IPAddress";
    const KEY_COMPANYNAME = "CompanyName";
    const KEY_LOCATION = "Location";
    const KEY_LAT = "Lat";
    const KEY_LON = "Lon";
    const KEY_COUNTRYCODE = "CountryCode";
    const KEY_LEGALNAME = "LegalName";

    use NS_traitArrayValue;

    private $_arrResponse;

    public function __construct(Array $arrResponse)
    {
        $this->_arrResponse = $arrResponse;
    }

    public function getStartIP()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_STARTIP],
            null
        );
    }
    public function getEndIP()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_ENDIP],
            null
        );
    }
    public function getIPRange()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_IPRANGE],
            null
        );
    }
    public function getIPAddress()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_IPADDRESS],
            null
        );
    }
    public function getCompanyName()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_COMPANYNAME],
            null
        );
    }
    // TODO: This will return location model
    public function getLocation()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_LOCATION],
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
    public function getLon()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_LON],
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
    public function getLegalName()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_LEGALNAME],
            null
        );
    }
}
