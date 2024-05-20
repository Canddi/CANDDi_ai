<?php

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
    const KEY_LNG = "Lng";
    const KEY_COUNTRYCODE = "CountryCode";
    const KEY_ISCLOUDHOST = "IsCloudHost";

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
    /**
     * @return  string|null
     *  string - The cloud domain this IP belongs to (eg. amazon.com)
     *  null   - IP was not detected as belonging to any cloud host
     */
    public function getIsCloudHost()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_ISCLOUDHOST],
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
    /**
     * @return  \CanddiAi\Lookup\Response\Company\Location|null
     */
    public function getLocation()
    {
        $arrLocation = $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_LOCATION],
            null
        );

        if (is_null($arrLocation)) {
            return null;
        }

        return new Location($arrLocation);
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
            [self::KEY_LNG],
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
}
