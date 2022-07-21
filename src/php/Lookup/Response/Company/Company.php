<?php

namespace CanddiAi\Lookup\Response\Company;

use CanddiAi\Traits\GetArrayValue as NS_traitArrayValue;

class Company
{
    const KEY_ALEXARANK = "AlexaRank";
    const KEY_COMPANYEMAILPLATFORMS = 'CompanyEmailPlatforms';
    const KEY_COMPANYNAME = "CompanyName";
    const KEY_CRN = "CRN";
    const KEY_DATEDOMAINLASTEDITED = 'DateDomainLastEdited';
    const KEY_DATEDOMAINREGISTERED = 'DateDomainRegistered';
    const KEY_DESCRIPTION = "Description";
    const KEY_EMAIL = 'Email';
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
    const KEY_KEYWORDS = 'Keywords';
    const KEY_LAT = "Lat";
    const KEY_LEGAL = 'Legal';
    const KEY_LEGALNAME = "LegalName";
    const KEY_LNG = "Lng";
    const KEY_LOCATION = "Location";
    const KEY_LOGO = "Logo";
    const KEY_MARKETCAP = "MarketCap";
    const KEY_PEOPLE = 'People';
    const KEY_PHONE = 'Phone';
    const KEY_PHONENUMBERS = "PhoneNumbers";
    const KEY_POSTCODE = "PostCode";
    const KEY_RAISED = "Raised";
    const KEY_REGION = "Region";
    const KEY_REVENUE = "Revenue";
    const KEY_REVENUEESTIMATED = "RevenueEstimated";
    const KEY_SECTORS = 'Sectors';
    const KEY_SIC = "SIC";
    const KEY_SOCIALMEDIA = "SocialMedia";
    const KEY_TAGS = "Tags";
    const KEY_VAT = "VAT";
    const KEY_WEBSITESCREENSHOT = "WebsiteScreenshot";
    const KEY_WEBSITEURL = "WebsiteURL";

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
    public function getCity()
    {
        $mdlLocation = $this->getLocation();

        if (!$mdlLocation) {
            return null;
        }

        return $mdlLocation->getCity();
    }
    public function getCompanyName()
    {
        $mdlLegal = $this->getLegal();
        if(!is_null($mdlLegal)) {
            $strLegalName = $mdlLegal->getLegalName();
            if(!is_null($strLegalName)) {
                return $strLegalName;
            }
        }
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_COMPANYNAME],
            null
        );
    }
    /**
     * @return  Array<EmailPlatform>
     */
    public function getCompanyEmailPlatforms()
    {
        $arrEmailPlatforms = $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_COMPANYEMAILPLATFORMS],
            null
        );

        if(empty($arrEmailPlatforms)) {
            return [];
        }

        $arrReturn = [];

        foreach($arrEmailPlatforms as $arrThisPlatform) {
            $arrReturn[] = new EmailPlatform($arrThisPlatform);
        }   

        return $arrReturn;
    }
    public function getCountryCode()
    {
        $mdlLocation = $this->getLocation();

        if (!$mdlLocation) {
            return null;
        }

        return $mdlLocation->getCountryCode();
    }
    public function getCRN()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_CRN],
            null
        );
    }
    public function getDateDomainLastEdited()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_DATEDOMAINLASTEDITED],
            null
        );
    }
    public function getDateDomainRegistered()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_DATEDOMAINREGISTERED],
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
    public function getEmail()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_EMAIL],
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
    public function getKeywords()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_KEYWORDS],
            null
        );
    }
    public function getLat()
    {
        $mdlLocation = $this->getLocation();

        if (!$mdlLocation) {
            return null;
        }

        return $mdlLocation->getLat();
    }
    /**
     * @return Legal|null
     */
    public function getLegal()
    {
        $arrLegal = $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_LEGAL],
            null
        );

        if(empty($arrLegal)) {
            return null;
        }

        return new Legal($arrLegal);
    }
    /**
     * @return  Location|null
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
        $mdlLocation = $this->getLocation();

        if (!$mdlLocation) {
            return null;
        }

        return $mdlLocation->getLng();
    }
    public function getMarketCap()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_MARKETCAP],
            null
        );
    }
    /**
     * @return Array<Person>
     */
    public function getPeople()
    {
        $arrPeople = $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_PEOPLE],
            null
        );

        if(empty($arrPeople)) {
            return [];
        }

        $arrReturn = [];
        foreach($arrPeople as $arrPerson) {
            $arrReturn[] = new Person($arrPerson);
        }
        
        return $arrReturn;
    }
    public function getPhone()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_PHONE],
            null
        );
    }
    public function getPhoneNumbers()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_PHONENUMBERS],
            []
        );
    }
    public function getPostCode()
    {
        $mdlLocation = $this->getLocation();

        if (!$mdlLocation) {
            return null;
        }

        return $mdlLocation->getPostCode();
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
        $mdlLocation = $this->getLocation();

        if (!$mdlLocation) {
            return null;
        }

        return $mdlLocation->getRegion();
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
    public function getSectors()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_SECTORS],
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
     * @return  Array<SocialMedia>|null
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
