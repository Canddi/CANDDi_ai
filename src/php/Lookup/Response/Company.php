<?php
/**
 * Wrapper for CANDDi Lookup
 * https://api.canddi.net
 *
 * @TODO REFACTOR THIS TO a separate composer package
 *
 * @author Tim Langley
 **/

namespace CanddiAi\Lookup\Response;

use CanddiAi\Traits\GetArrayValue as NS_traitArrayValue;

class Company
{
    const KEY_DESCRIPTION       = 'Description';
    const KEY_WEBSITE           = 'WebsiteURL';
    const KEY_EMAILS            = 'EmailAddresses';
    const KEY_SOCIAL            = 'SocialMedia';
    const KEY_LOCATION          = 'Location';
    const KEY_LAT               = 'Lat';
    const KEY_LON               = 'Lon';
    const KEY_ADDRESS_LON       = 'Lng';
    const KEY_CITY              = 'City';
    const KEY_COUNTRYCODE       = 'CountryCode';
    const KEY_LOGO              = 'Logo';
    const KEY_NAME              = 'CompanyName';
    const KEY_INDUSTRY          = 'Industry';
    const KEY_PHONES            = 'PhoneNumbers';
    const KEY_INDUSTRY_SECTOR   = 'IndustrySector';
    const KEY_INDUSTRY_GROUP    = 'IndustryGroup';
    const KEY_INDUSTRY_SIC      = 'IndustrySIC';
    const KEY_INDUSTRY_NAICS    = 'IndustryNAICS';
    const KEY_TAGS              = 'Tags';
    const KEY_ALEXA_RANK        = 'AlexaRank';
    const KEY_EMPLOYEES         = 'Employees';
    const KEY_EMPLOYEE_RANGE    = 'EmployeeRange';
    const KEY_MARKETCAP         = 'MarketCap';
    const KEY_RAISED            = 'Raised';
    const KEY_REVENUE           = 'Revenue';
    const KEY_REVENUE_ESTIMATED = 'RevenueEstimated';
    const KEY_ADDRESS           = 'Address';
    const KEY_LINE1             = 'Line1';
    const KEY_LINE2             = 'Line2';
    // The PostalCode is the address in the address object
    const KEY_POSTALCODE        = 'PostalCode';
    // PostCode is for the the postcode for the IP from 1_Company_IP
    const KEY_POSTCODE          = 'PostCode';
    const KEY_TYPE              = 'Type';
    const KEY_REGION            = 'Region';
    const KEY_ISISP             = 'bIsISP';

    use NS_traitArrayValue;

    private $_arrResponse;

    public function __construct(Array $arrResponse)
    {
        $this->_arrResponse = $arrResponse;
    }
    public function getAddressCity()
    {
        return $this->_getArrayValue(
            $this->getLocationAddress(),
            [
                self::KEY_CITY
            ],
            ""
        );
    }
    public function getAddressLat()
    {
        return $this->_getArrayValue(
            $this->getLocation(),
            [
                self::KEY_LAT
            ],
            ""
        );
    }
    public function getAddressLon()
    {
        return $this->_getArrayValue(
            $this->getLocation(),
            [
                self::KEY_ADDRESS_LON
            ],
            ""
        );
    }
    public function getAddressLine1()
    {
        return $this->_getArrayValue(
            $this->getLocationAddress(),
            [
                self::KEY_LINE1
            ],
            ""
        );
    }
    public function getAddressLine2()
    {
        return $this->_getArrayValue(
            $this->getLocationAddress(),
            [
                self::KEY_LINE2
            ],
            ""
        );
    }
    public function getAddressPostCode()
    {
        return $this->_getArrayValue(
            $this->getLocationAddress(),
            [
                self::KEY_POSTALCODE
            ],
            ""
        );
    }
    public function getAlexaRank()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_ALEXA_RANK
            ],
            null
        );
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

    /* https://canddi.atlassian.net/browse/CS-9790
    /* *
     * Produces a Canddi_Core_Company based on the data in this response
     *
     * @return Canddi_Core_Company || null
     * /
    public function getCoreCompany()
    {
        $strCompanyName = $this->getName();
        if (empty($strCompanyName)) {
            return null;
        }

        $strDescription     = $this->getDescription();
        $strLogo            = $this->getLogo();
        $strIndustry        = $this->getIndustry();
        $strWebsite         = $this->getWebsite();
        $arrPhones          = $this->getPhones();
        $arrEmails          = $this->getEmailAddresses();
        $strIndustrySector  = $this->getIndustrySector();
        $strIndustryGroup   = $this->getIndustryGroup();
        $strIndustrySIC     = $this->getIndustrySIC();
        $strIndustryNAICS   = $this->getIndustryNAICS();
        $arrTags            = $this->getTags();
        $intAlexa           = $this->getAlexaRank();
        $intEmployees       = $this->getEmployees();
        $strEmployees       = $this->getEmployeeRange();
        $intMarketCap       = $this->getMarketCap();
        $intRaised          = $this->getRaised();
        $intRevenue         = $this->getRevenue();
        $strRevenue         = $this->getRevenueEstimated();
        $arrSocial          = $this->getSocialProfiles();
        $strFacebook        = null;
        $strTwitter         = null;
        $strLinkedIn        = null;
        $strLineOne         = null;
        $strLineTwo         = null;
        $strCity            = null;
        $strPostalCode      = null;

        if (!empty($arrSocial)) {
            foreach ($arrSocial as $mdlSocial) {
                $strSocialType = $mdlSocial->getType();
                switch ($strSocialType) {
                    case 'Facebook':
                        $strFacebook = $mdlSocial->getURL();
                        break;
                    case 'Twitter':
                        $strTwitter = $mdlSocial->getURL();
                        break;
                    case 'LinkedIn';
                        $strLinkedIn = $mdlSocial->getURL();
                        break;
                    default:
                        break;
                }
            }
        }

        if (!empty($this->getLocationAddress())) {
            $strLineOne     = $this->getAddressLine1();
            $strLineTwo     = $this->getAddressLine2();
            $strCity        = $this->getAddressCity();
            $strPostalCode  = $this->getAddressPostCode();
        }

        $coreCompany = \Canddi_Core_Company::create(
            $strCompanyName,
            null,
            $strDescription,
            $strFacebook,
            $strTwitter,
            $strLinkedIn,
            $strLogo,
            $strIndustry,
            $strWebsite,
            $arrPhones,
            $arrEmails,
            $strLineOne,
            $strLineTwo,
            $strCity,
            $strPostalCode,
            $strIndustrySector,
            $strIndustryGroup,
            $strIndustrySIC,
            $strIndustryNAICS,
            $arrTags,
            $intAlexa,
            $intEmployees,
            $strEmployees,
            $intMarketCap,
            $intRaised,
            $intRevenue,
            $strRevenue
        );
        return $coreCompany;
    }
    /**
     * Produces a Canddi_Core_Location based on the Lon/Lat in this response
     *
     * @return Canddi_Core_Location || null
     * /
    public function getCoreLocation()
    {
        if (empty($this->getLocation())) {
            return null;
        }

        $dblLat             = $this->getAddressLat();
        $dblLng             = $this->getAddressLon();

        if (empty($dblLat) || empty($dblLng)) {
            return null;
        }

        $coreLocation = \Canddi_Core_Location::create(
            floatval($dblLat),
            floatval($dblLng),
            \Canddi_Core_Location::TYPE_FIXED_ADDRESS
        );

        return $coreLocation;
    }
        END https://canddi.atlassian.net/browse/CS-9790
    */
    public function getCountryCode()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_COUNTRYCODE
            ],
            ""
        );
    }
    public function getDescription()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_DESCRIPTION
            ],
            null
        );
    }
    public function getLogo()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_LOGO
            ],
            ""
        );
    }
    public function getEmailAddresses()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_EMAILS
            ],
            []
        );
    }
    public function getEmployees()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_EMPLOYEES
            ],
            null
        );
    }
    public function getEmployeeRange()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_EMPLOYEE_RANGE
            ],
            ""
        );
    }
    public function getIndustry()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_INDUSTRY
            ],
            ""
        );
    }
    public function getIndustryGroup()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_INDUSTRY_GROUP
            ],
            ""
        );
    }
    public function getIndustryNAICS()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_INDUSTRY_NAICS
            ],
            ""
        );
    }
    public function getIndustrySector()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_INDUSTRY_SECTOR
            ],
            ""
        );
    }
    public function getIndustrySIC()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_INDUSTRY_SIC
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
    public function getLocation()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_LOCATION
            ],
            []
        );
    }
    public function getLocationAddress()
    {
        return $this->_getArrayValue(
            $this->getLocation(),
            [
                self::KEY_ADDRESS
            ],
            []
        );
    }
    public function getLon()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_LON
            ],
            ""
        );
    }
    public function getMarketCap()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_MARKETCAP
            ],
            ""
        );
    }
    public function getName()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_NAME
            ],
            ""
        );
    }
    public function getPhones()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_PHONES
            ],
            []
        );
    }
    public function getPostCode()
    {
        return $this->_getArrayValue(
            $this->getLocationAddress(),
            [
                self::KEY_POSTCODE
            ],
            ""
        );
    }
    public function getRaised()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_RAISED
            ],
            ""
        );
    }
    public function getRegion()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_REGION
            ],
            ""
        );
    }
    public function getRevenue()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_REVENUE
            ],
            ""
        );
    }
    public function getRevenueEstimated()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_REVENUE_ESTIMATED
            ],
            ""
        );
    }
    public function getSocialProfiles()
    {
        $arrProfiles  = $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_SOCIAL
            ],
            []
        );
        $arrReturn  = [];

        //This is a horrible way of returning
        // too many loops = slow code
        // @TODO refactor with an Iterator
        foreach ($arrProfiles as $strKey => $arrProfile) {
            $arrReturn[] = new Item\Social(
                array_merge(
                    $arrProfile,
                    [
                        'typeId'  =>  $strKey
                    ]
                )
            );
        }
        return $arrReturn;
    }
    public function getTags()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_TAGS
            ],
            []
        );
    }
    public function getType()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_TYPE
            ],
            ""
        );
    }
    public function getWebsite()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_WEBSITE
            ],
            null
        );
    }
    public function isISP()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_ISISP
            ],
            false
        );
    }
}
