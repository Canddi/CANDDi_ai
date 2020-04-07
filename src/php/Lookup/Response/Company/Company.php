<?php

namespace CanddiAi\Lookup\Response\Company;

use CanddiAi\Traits\GetArrayValue as NS_traitArrayValue;

class Company
{
    const KEY_ALEXARANK = "AlexaRank";
    const KEY_BISISP = "bIsISP";
    const KEY_CITY = "City";
    const KEY_COMPANYNAME = "CompanyName";
    const KEY_COUNTRYCODE = "CountryCode";
    const KEY_CRN = "CRN";
    const KEY_DEBUG = "Debug";
    const KEY_DESCRIPTION = "Description";
    const KEY_EMAILADDRESSES = "EmailAddresses";
    const KEY_EMPLOYEERANGE = "EmployeeRange";
    const KEY_EMPLOYEES = "Employees";
    const KEY_HEADING = "Heading";
    const KEY_HOSTNAME = "Hostname";
    const KEY_INDUSTRY = "Industry";
    const KEY_INDUSTRYGROUP = "IndustryGroup";
    const KEY_INDUSTRYNAICS = "IndustryNAICS";
    const KEY_INDUSTRYSECTOR = "IndustrySector";
    const KEY_INDUSTRYSIC = "IndustrySIC";
    const KEY_LAT = "Lat";
    const KEY_LEGALNAME = "LegalName";
    const KEY_LOCATION = "Location";
    const KEY_LOGO = "Logo";
    const KEY_LON = "Lon";
    const KEY_MARKETCAP = "MarketCap";
    const KEY_ORIGIP = "OrigIP";
    const KEY_PHONENUMBERS = "PhoneNumbers";
    const KEY_POSTCODE = "PostCode";
    const KEY_RAISED = "Raised";
    const KEY_REGION = "Region";
    const KEY_REVENUE = "Revenue";
    const KEY_REVENUEESTIMATED = "RevenueEstimated";
    const KEY_SIC = "SIC";
    const KEY_SOCIALMEDIA = "SocialMedia";
    const KEY_TAGS = "Tags";
    const KEY_VAT = "VAT";
    const KEY_WEBSITEURL = "WebsiteURL";
    const KEY_WEBSITESCREENSHOT = "WebsiteScreenshot";

    use NS_traitArrayValue;

    private $_arrResponse;

    public function __construct(Array $arrResponse)
    {
        $this->_arrResponse = $arrResponse;
    }

    public function getAlexaRank()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_ALEXARANK],
            null
        );
    }
    public function getbIsISP()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_BISISP],
            null
        );
    }
    public function getCity()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_CITY],
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
    public function getCountryCode()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_COUNTRYCODE],
            null
        );
    }
    public function getCRN()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_CRN],
            null
        );
    }
    public function getDebug()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_DEBUG],
            null
        );
    }
    public function getDescription()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_DESCRIPTION],
            null
        );
    }
    public function getEmailAddresses()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_EMAILADDRESSES],
            null
        );
    }
    public function getEmployeeRange()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_EMPLOYEERANGE],
            null
        );
    }
    public function getEmployees()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_EMPLOYEES],
            null
        );
    }
    public function getHeading()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_HEADING],
            null
        );
    }
    public function getHostname()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_HOSTNAME],
            null
        );
    }
    public function getIndustry()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_INDUSTRY],
            null
        );
    }
    public function getIndustryGroup()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_INDUSTRYGROUP],
            null
        );
    }
    public function getIndustryNAICS()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_INDUSTRYNAICS],
            null
        );
    }
    public function getIndustrySector()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_INDUSTRYSECTOR],
            null
        );
    }
    public function getIndustrySIC()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_INDUSTRYSIC],
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
    public function getLegalName()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_LEGALNAME],
            null
        );
    }
    /**
     * @return  CanddiAi\Lookup\Response\Company\Location|null
     */
    public function getLocation()
    {
        $arrLocation = $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_LOCATION],
            null
        );

        if(is_null($arrLocation)) {
            return null;
        }

        return new Location($arrLocation);
    }
    public function getLogo()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_LOGO],
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
    public function getMarketCap()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_MARKETCAP],
            null
        );
    }
    public function getOrigIP()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_ORIGIP],
            null
        );
    }
    public function getPhoneNumbers()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_PHONENUMBERS],
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
    public function getRaised()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_RAISED],
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
    public function getRevenue()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_REVENUE],
            null
        );
    }
    public function getRevenueEstimated()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_REVENUEESTIMATED],
            null
        );
    }
    public function getSIC()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_SIC],
            null
        );
    }
    /**
     * @return  Array<CanddiAi\Lookup\Response\Company\SocialMedia>|null
     */
    public function getSocialMedia()
    {
        $arrSocialMedia = $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_SOCIALMEDIA],
            null
        );

        if(is_null($arrSocialMedia)) {
            return null;
        }

        $arrReturn = [];

        foreach($arrSocialMedia as $arrThisSocial) {
            $arrReturn[] = new SocialMedia($arrThisSocial);
        }

        return $arrReturn;
    }
    public function getTags()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_TAGS],
            null
        );
    }
    public function getVAT()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_VAT],
            null
        );
    }
    public function getWebsiteURL()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_WEBSITEURL],
            null
        );
    }
    public function getWebsiteScreenshot()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_WEBSITESCREENSHOT],
            null
        );
    }
}
