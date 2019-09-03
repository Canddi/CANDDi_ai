<?php
/**
 * Service for CANDDi Company Lookup
 *
 * @author Tim Langley
 **/

namespace CanddiAi\Lookup;

use CanddiAi\Singleton\InterfaceSingleton;
use CanddiAi\Response\Company as ResponseCompany;
use CanddiAi\Traits\TraitSingleton;
use CanddiAi\Traits\GetArrayValue as NS_traitArrayValue;

class Company
    implements InterfaceSingleton
{
    use TraitSingleton;
    use NS_traitArrayValue;

    const c_URL_CompanyName = 'lookup/companyname/%s';
    const c_URL_Host    = 'lookup/hostname/%s';
    const c_URL_IP      = 'lookup/ip/%s';
    const c_URL_Name    = 'lookup/company/%s';

    /**
     * Calls https://ip.candd.ai/lookup/companyname/[companyname]
     * end point and returns an array of data
     *
     * @param   string $strHostname
     * @param   optional string $strAccountURL
     * @param   optional string $guidContactId
     *
     * @return  Response\Company
     *
    **/
    public function lookupCompanyName(
        $strCompanyName,
        $strAccountURL = null,
        $guidContactId = null
    )
    {
        $strURL             = sprintf(self::c_URL_CompanyName, $strCompanyName);
        $arrQuery           = [
            'accounturl'    => $strAccountURL,
            'contactid'     => $guidContactId
        ];
        try {
            $arrResponse    = $this->_callEndpoint(
                $strURL,
                $arrQuery
            );
        } catch(\Exception $e) {
            throw new \Exception(
                "Service:Company:CompanyName returned error for ($strCompanyName) ".
                " on Account ($strAccountURL), Contact ($guidContactId) ".
                $e->getMessage()
            );
        }

        $arrOldResponse = [
            "Location" => [
                "Address" => [
                    "Line1" => $this->_getArrayValue(
                        $arrResponse,
                        [
                            "Company",
                            "Location",
                            "Line1"
                        ],
                        ""
                    ),
                    "Line2" => $this->_getArrayValue(
                        $arrResponse,
                        [
                            "Company",
                            "Location",
                            "Line2"
                        ],
                        ""
                    ),
                    "PostalCode" => $this->_getArrayValue(
                        $arrResponse,
                        [
                            "Company",
                            "Location",
                            "PostCode"
                        ],
                        ""
                    ),
                    "PostCode" => $this->_getArrayValue(
                        $arrResponse,
                        [
                            "Company",
                            "Location",
                            "PostCode"
                        ],
                        ""
                    ),
                    "City" => $this->_getArrayValue(
                        $arrResponse,
                        [
                            "Company",
                            "Location",
                            "City"
                        ],
                        ""
                    ),
                    "Country" => $this->_getArrayValue(
                        $arrResponse,
                        [
                            "Company",
                            "Location",
                            "Lng"
                        ],
                        ""
                    )
                ],
                "FormattedAddress" => $this->_getArrayValue(
                    $arrResponse,
                    [
                        "Company",
                        "Location",
                        "FormattedAddress"
                    ],
                    ""
                ),
                "Region" => $this->_getArrayValue(
                    $arrResponse,
                    [
                        "Company",
                        "Location",
                        "Region"
                    ],
                    ""
                ),
                "CountryCode" => $this->_getArrayValue(
                    $arrResponse,
                    [
                        "Company",
                        "Location",
                        "CountryCode"
                    ],
                    ""
                ),
                "Lat" => $this->_getArrayValue(
                    $arrResponse,
                    [
                        "Company",
                        "Location",
                        "Lat"
                    ],
                    ""
                ),
                "Lon" => $this->_getArrayValue(
                    $arrResponse,
                    [
                        "Company",
                        "Location",
                        "Lon"
                    ],
                    ""
                ),
                "Lng" => $this->_getArrayValue(
                    $arrResponse,
                    [
                        "Company",
                        "Location",
                        "Lng"
                    ],
                    ""
                )
            ],
            "AlexaRank" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "AlexaRank"
                ],
                null
            ),
            "Description" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "Description"
                ],
                null
            ),
            "Logo" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "Logo"
                ],
                ""
            ),
            "EmailAddresses" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "EmailAddresses"
                ],
                ""
            ),
            "Employees" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "Employees"
                ],
                null
            ),
            "EmployeeRange" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "EmployeeRange"
                ],
                ""
            ),
            "Industry" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "Industry"
                ],
                ""
            ),
            "IndustrySector" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "IndustrySector"
                ],
                ""
            ),
            "IndustryGroup" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "IndustryGroup"
                ],
                ""
            ),
            "IndustrySIC" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "IndustrySIC"
                ],
                ""
            ),
            "IndustryNAICS" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "IndustryNAICS"
                ],
                ""
            ),
            "MarketCap" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "MarketCap"
                ],
                ""
            ),
            "CompanyName" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "CompanyName"
                ],
                $this->_getArrayValue(
                    $arrResponse,
                    [
                        "IP",
                        "CompanyName"
                    ],
                    ""
                )
            ),
            "PhoneNumbers" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "PhoneNumbers"
                ],
                ""
            ),
            "Raised" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "Raised"
                ],
                ""
            ),
            "Revenue" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "Revenue"
                ],
                ""
            ),
            "RevenueEstimated" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "RevenueEstimated"
                ],
                ""
            ),
            "SocialMedia" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "SocialMedia"
                ],
                ""
            ),
            "Tags" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "Tags"
                ],
                ""
            ),
            "WebsiteURL" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "WebsiteURL"
                ],
                ""
            ),
            "CountryCode" => $this->_getArrayValue(
                $arrResponse,
                [
                    "IP",
                    "Location",
                    "CountryCode"
                ],
                ""
            ),
            "Lat" => $this->_getArrayValue(
                $arrResponse,
                [
                    "IP",
                    "Location",
                    "Lat"
                ],
                ""
            ),
            "Lon" => $this->_getArrayValue(
                $arrResponse,
                [
                    "IP",
                    "Location",
                    "Lon"
                ],
                ""
            ),
            "Region" => $this->_getArrayValue(
                $arrResponse,
                [
                    "IP",
                    "Location",
                    "Region"
                ],
                ""
            ),
            "Type" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Type"
                ],
                ""
            ),
            "PostCode" => $this->_getArrayValue(
                $arrResponse,
                [
                    "IP",
                    "Location",
                    "PostCode"
                ],
                ""
            ),
            "City" => $this->_getArrayValue(
                $arrResponse,
                [
                    "IP",
                    "Location",
                    "City"
                ],
                ""
            ),
            "CountryCode" => $this->_getArrayValue(
                $arrResponse,
                [
                    "IP",
                    "Location",
                    "CountryCode"
                ],
                ""
            )
        ];
        if ($arrOldResponse["Type"] == 1 || $arrOldResponse["Type"] == 2) {
            $arrOldResponse["bIsISP"] = true;
        } else {
            $arrOldResponse["bIsISP"] = false;
        }
        $arrResponseToPass = [];
        foreach($arrOldResponse as $key => $value) {
            if (!is_array($value)) {
                if ($value || $key == "bIsISP" || $key == "Type") {
                    $arrResponseToPass[$key] = $value;
                }
            } else {
                if (
                    isset($arrOldResponse["Location"]) &&
                    isset($arrOldResponse["Location"]["Lat"]) &&
                    $arrOldResponse["Location"]["Lat"] != ""
                ) {
                    $arrResponseToPass["Location"] = $arrOldResponse["Location"];
                }
            }
        }
        return new Response\Company($arrResponseToPass);
    }
    /**
     * Calls https://ip.candd.ai/lookup/host/[hostname]
     * end point and returns an array of data
     *
     * @param   string $strHostname
     * @param   optional string $strAccountURL
     * @param   optional string $guidContactId
     *
     * @return  Response\Company
     *
    **/
    public function lookupHost(
        $strHostName,
        $strAccountURL = null,
        $guidContactId = null
    )
    {
        $strURL             = sprintf(self::c_URL_Host, $strHostName);
        $arrQuery           = [
            'accounturl'    => $strAccountURL,
            'contactid'     => $guidContactId
        ];

        try {
            $arrResponse    = $this->_callEndpoint(
                $strURL,
                $arrQuery
            );
        } catch(\Exception $e) {
            throw new \Exception(
                "Service:Company:Host returned error for ($strHostName) ".
                " on Account ($strAccountURL), Contact ($guidContactId) ".
                $e->getMessage()
            );
        }

        $arrOldResponse = [
            "Location" => [
                "Address" => [
                    "Line1" => $this->_getArrayValue(
                        $arrResponse,
                        [
                            "Company",
                            "Location",
                            "Line1"
                        ],
                        ""
                    ),
                    "Line2" => $this->_getArrayValue(
                        $arrResponse,
                        [
                            "Company",
                            "Location",
                            "Line2"
                        ],
                        ""
                    ),
                    "PostalCode" => $this->_getArrayValue(
                        $arrResponse,
                        [
                            "Company",
                            "Location",
                            "PostCode"
                        ],
                        ""
                    ),
                    "PostCode" => $this->_getArrayValue(
                        $arrResponse,
                        [
                            "Company",
                            "Location",
                            "PostCode"
                        ],
                        ""
                    ),
                    "City" => $this->_getArrayValue(
                        $arrResponse,
                        [
                            "Company",
                            "Location",
                            "City"
                        ],
                        ""
                    ),
                    "Country" => $this->_getArrayValue(
                        $arrResponse,
                        [
                            "Company",
                            "Location",
                            "Lng"
                        ],
                        ""
                    )
                ],
                "FormattedAddress" => $this->_getArrayValue(
                    $arrResponse,
                    [
                        "Company",
                        "Location",
                        "FormattedAddress"
                    ],
                    ""
                ),
                "Region" => $this->_getArrayValue(
                    $arrResponse,
                    [
                        "Company",
                        "Location",
                        "Region"
                    ],
                    ""
                ),
                "CountryCode" => $this->_getArrayValue(
                    $arrResponse,
                    [
                        "Company",
                        "Location",
                        "CountryCode"
                    ],
                    ""
                ),
                "Lat" => $this->_getArrayValue(
                    $arrResponse,
                    [
                        "Company",
                        "Location",
                        "Lat"
                    ],
                    ""
                ),
                "Lon" => $this->_getArrayValue(
                    $arrResponse,
                    [
                        "Company",
                        "Location",
                        "Lon"
                    ],
                    ""
                ),
                "Lng" => $this->_getArrayValue(
                    $arrResponse,
                    [
                        "Company",
                        "Location",
                        "Lng"
                    ],
                    ""
                )
            ],
            "AlexaRank" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "AlexaRank"
                ],
                null
            ),
            "Description" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "Description"
                ],
                null
            ),
            "Logo" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "Logo"
                ],
                ""
            ),
            "EmailAddresses" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "EmailAddresses"
                ],
                ""
            ),
            "Employees" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "Employees"
                ],
                null
            ),
            "EmployeeRange" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "EmployeeRange"
                ],
                ""
            ),
            "Industry" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "Industry"
                ],
                ""
            ),
            "IndustrySector" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "IndustrySector"
                ],
                ""
            ),
            "IndustryGroup" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "IndustryGroup"
                ],
                ""
            ),
            "IndustrySIC" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "IndustrySIC"
                ],
                ""
            ),
            "IndustryNAICS" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "IndustryNAICS"
                ],
                ""
            ),
            "MarketCap" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "MarketCap"
                ],
                ""
            ),
            "CompanyName" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "CompanyName"
                ],
                $this->_getArrayValue(
                    $arrResponse,
                    [
                        "IP",
                        "CompanyName"
                    ],
                    ""
                )
            ),
            "PhoneNumbers" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "PhoneNumbers"
                ],
                ""
            ),
            "Raised" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "Raised"
                ],
                ""
            ),
            "Revenue" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "Revenue"
                ],
                ""
            ),
            "RevenueEstimated" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "RevenueEstimated"
                ],
                ""
            ),
            "SocialMedia" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "SocialMedia"
                ],
                ""
            ),
            "Tags" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "Tags"
                ],
                ""
            ),
            "WebsiteURL" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "WebsiteURL"
                ],
                ""
            ),
            "CountryCode" => $this->_getArrayValue(
                $arrResponse,
                [
                    "IP",
                    "Location",
                    "CountryCode"
                ],
                ""
            ),
            "Lat" => $this->_getArrayValue(
                $arrResponse,
                [
                    "IP",
                    "Location",
                    "Lat"
                ],
                ""
            ),
            "Lon" => $this->_getArrayValue(
                $arrResponse,
                [
                    "IP",
                    "Location",
                    "Lon"
                ],
                ""
            ),
            "Region" => $this->_getArrayValue(
                $arrResponse,
                [
                    "IP",
                    "Location",
                    "Region"
                ],
                ""
            ),
            "Type" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Type"
                ],
                ""
            ),
            "PostCode" => $this->_getArrayValue(
                $arrResponse,
                [
                    "IP",
                    "Location",
                    "PostCode"
                ],
                ""
            ),
            "City" => $this->_getArrayValue(
                $arrResponse,
                [
                    "IP",
                    "Location",
                    "City"
                ],
                ""
            ),
            "CountryCode" => $this->_getArrayValue(
                $arrResponse,
                [
                    "IP",
                    "Location",
                    "CountryCode"
                ],
                ""
            )
        ];
        if ($arrOldResponse["Type"] == 1 || $arrOldResponse["Type"] == 2) {
            $arrOldResponse["bIsISP"] = true;
        } else {
            $arrOldResponse["bIsISP"] = false;
        }
        $arrResponseToPass = [];
        foreach($arrOldResponse as $key => $value) {
            if (!is_array($value)) {
                if ($value || $key == "bIsISP" || $key == "Type") {
                    $arrResponseToPass[$key] = $value;
                }
            } else {
                if (
                    isset($arrOldResponse["Location"]) &&
                    isset($arrOldResponse["Location"]["Lat"]) &&
                    $arrOldResponse["Location"]["Lat"] != ""
                ) {
                    $arrResponseToPass["Location"] = $arrOldResponse["Location"];
                }
            }
        }
        return new Response\Company($arrResponseToPass);
    }
    /**
     * Calls https://api.candd.net/lookup/ip/[ipaddress]
     * end point and returns an array of data
     *
     * @param   string $mixedIPAddress (either dot notation or integer)
     * @param   optional string $strAccountURL
     * @param   optional string $guidContactId
     *
     * @return  Response\Company
     *
    **/
    public function lookupIP(
        $mixedIPAddress,
        $strAccountURL = null,
        $guidContactId = null
    )
    {
        $strURL             = sprintf(self::c_URL_IP, $mixedIPAddress);
        $arrQuery           = [
            'accounturl'    => $strAccountURL,
            'contactid'     => $guidContactId
        ];

        try {
            $arrResponse    = $this->_callEndpoint(
                $strURL,
                $arrQuery
            );
        } catch(\Exception $e) {
            throw new \Exception(
                "Service:Company:IP returned error for ($mixedIPAddress) ".
                " on Account ($strAccountURL), Contact ($guidContactId) ".
                $e->getMessage()
            );
        }
        $arrOldResponse = [
            "Location" => [
                "Address" => [
                    "Line1" => $this->_getArrayValue(
                        $arrResponse,
                        [
                            "Company",
                            "Location",
                            "Line1"
                        ],
                        ""
                    ),
                    "Line2" => $this->_getArrayValue(
                        $arrResponse,
                        [
                            "Company",
                            "Location",
                            "Line2"
                        ],
                        ""
                    ),
                    "PostalCode" => $this->_getArrayValue(
                        $arrResponse,
                        [
                            "Company",
                            "Location",
                            "PostCode"
                        ],
                        ""
                    ),
                    "PostCode" => $this->_getArrayValue(
                        $arrResponse,
                        [
                            "Company",
                            "Location",
                            "PostCode"
                        ],
                        ""
                    ),
                    "City" => $this->_getArrayValue(
                        $arrResponse,
                        [
                            "Company",
                            "Location",
                            "City"
                        ],
                        ""
                    ),
                    "Country" => $this->_getArrayValue(
                        $arrResponse,
                        [
                            "Company",
                            "Location",
                            "Lng"
                        ],
                        ""
                    )
                ],
                "FormattedAddress" => $this->_getArrayValue(
                    $arrResponse,
                    [
                        "Company",
                        "Location",
                        "FormattedAddress"
                    ],
                    ""
                ),
                "Region" => $this->_getArrayValue(
                    $arrResponse,
                    [
                        "Company",
                        "Location",
                        "Region"
                    ],
                    ""
                ),
                "CountryCode" => $this->_getArrayValue(
                    $arrResponse,
                    [
                        "Company",
                        "Location",
                        "CountryCode"
                    ],
                    ""
                ),
                "Lat" => $this->_getArrayValue(
                    $arrResponse,
                    [
                        "Company",
                        "Location",
                        "Lat"
                    ],
                    ""
                ),
                "Lon" => $this->_getArrayValue(
                    $arrResponse,
                    [
                        "Company",
                        "Location",
                        "Lon"
                    ],
                    ""
                ),
                "Lng" => $this->_getArrayValue(
                    $arrResponse,
                    [
                        "Company",
                        "Location",
                        "Lng"
                    ],
                    ""
                )
            ],
            "AlexaRank" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "AlexaRank"
                ],
                null
            ),
            "Description" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "Description"
                ],
                null
            ),
            "Logo" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "Logo"
                ],
                ""
            ),
            "EmailAddresses" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "EmailAddresses"
                ],
                ""
            ),
            "Employees" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "Employees"
                ],
                null
            ),
            "EmployeeRange" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "EmployeeRange"
                ],
                ""
            ),
            "Industry" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "Industry"
                ],
                ""
            ),
            "IndustrySector" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "IndustrySector"
                ],
                ""
            ),
            "IndustryGroup" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "IndustryGroup"
                ],
                ""
            ),
            "IndustrySIC" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "IndustrySIC"
                ],
                ""
            ),
            "IndustryNAICS" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "IndustryNAICS"
                ],
                ""
            ),
            "MarketCap" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "MarketCap"
                ],
                ""
            ),
            "CompanyName" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "CompanyName"
                ],
                $this->_getArrayValue(
                    $arrResponse,
                    [
                        "IP",
                        "CompanyName"
                    ],
                    ""
                )
            ),
            "PhoneNumbers" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "PhoneNumbers"
                ],
                ""
            ),
            "Raised" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "Raised"
                ],
                ""
            ),
            "Revenue" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "Revenue"
                ],
                ""
            ),
            "RevenueEstimated" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "RevenueEstimated"
                ],
                ""
            ),
            "SocialMedia" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "SocialMedia"
                ],
                ""
            ),
            "Tags" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "Tags"
                ],
                ""
            ),
            "WebsiteURL" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "WebsiteURL"
                ],
                ""
            ),
            "CountryCode" => $this->_getArrayValue(
                $arrResponse,
                [
                    "IP",
                    "Location",
                    "CountryCode"
                ],
                ""
            ),
            "Lat" => $this->_getArrayValue(
                $arrResponse,
                [
                    "IP",
                    "Location",
                    "Lat"
                ],
                ""
            ),
            "Lon" => $this->_getArrayValue(
                $arrResponse,
                [
                    "IP",
                    "Location",
                    "Lon"
                ],
                ""
            ),
            "Region" => $this->_getArrayValue(
                $arrResponse,
                [
                    "IP",
                    "Location",
                    "Region"
                ],
                ""
            ),
            "Type" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Type"
                ],
                ""
            ),
            "PostCode" => $this->_getArrayValue(
                $arrResponse,
                [
                    "IP",
                    "Location",
                    "PostCode"
                ],
                ""
            ),
            "City" => $this->_getArrayValue(
                $arrResponse,
                [
                    "IP",
                    "Location",
                    "City"
                ],
                ""
            ),
            "CountryCode" => $this->_getArrayValue(
                $arrResponse,
                [
                    "IP",
                    "Location",
                    "CountryCode"
                ],
                ""
            )
        ];
        if ($arrOldResponse["Type"] == 1 || $arrOldResponse["Type"] == 2) {
            $arrOldResponse["bIsISP"] = true;
        } else {
            $arrOldResponse["bIsISP"] = false;
        }
        $arrResponseToPass = [];
        foreach($arrOldResponse as $key => $value) {
            if (!is_array($value)) {
                if ($value || $key == "bIsISP" || $key == "Type") {
                    $arrResponseToPass[$key] = $value;
                }
            } else {
                if (
                    isset($arrOldResponse["Location"]) &&
                    isset($arrOldResponse["Location"]["Lat"]) &&
                    $arrOldResponse["Location"]["Lat"] != ""
                ) {
                    $arrResponseToPass["Location"] = $arrOldResponse["Location"];
                }
            }
        }
        return new Response\Company($arrResponseToPass);
    }

    public function lookupName(
        $strCompanyName,
        $strAccountURL = null,
        $guidContactId = null
    )
    {
        $strURL             = sprintf(self::c_URL_Name, $strCompanyName);
        $arrQuery           = [
            'accounturl'    => $strAccountURL,
            'contactid'     => $guidContactId
        ];

        try {
            $arrResponse    = $this->_callEndpoint(
                $strURL,
                $arrQuery
            );
        } catch(\Exception $e) {
            throw new \Exception(
                "Service:Company:Name returned error for ($strCompanyName) ".
                " on Account ($strAccountURL), Contact ($guidContactId) ".
                $e->getMessage()
            );
        }

        $arrOldResponse = [
            "Location" => [
                "Address" => [
                    "Line1" => $this->_getArrayValue(
                        $arrResponse,
                        [
                            "Company",
                            "Location",
                            "Line1"
                        ],
                        ""
                    ),
                    "Line2" => $this->_getArrayValue(
                        $arrResponse,
                        [
                            "Company",
                            "Location",
                            "Line2"
                        ],
                        ""
                    ),
                    "PostalCode" => $this->_getArrayValue(
                        $arrResponse,
                        [
                            "Company",
                            "Location",
                            "PostCode"
                        ],
                        ""
                    ),
                    "PostCode" => $this->_getArrayValue(
                        $arrResponse,
                        [
                            "Company",
                            "Location",
                            "PostCode"
                        ],
                        ""
                    ),
                    "City" => $this->_getArrayValue(
                        $arrResponse,
                        [
                            "Company",
                            "Location",
                            "City"
                        ],
                        ""
                    ),
                    "Country" => $this->_getArrayValue(
                        $arrResponse,
                        [
                            "Company",
                            "Location",
                            "Lng"
                        ],
                        ""
                    )
                ],
                "FormattedAddress" => $this->_getArrayValue(
                    $arrResponse,
                    [
                        "Company",
                        "Location",
                        "FormattedAddress"
                    ],
                    ""
                ),
                "Region" => $this->_getArrayValue(
                    $arrResponse,
                    [
                        "Company",
                        "Location",
                        "Region"
                    ],
                    ""
                ),
                "CountryCode" => $this->_getArrayValue(
                    $arrResponse,
                    [
                        "Company",
                        "Location",
                        "CountryCode"
                    ],
                    ""
                ),
                "Lat" => $this->_getArrayValue(
                    $arrResponse,
                    [
                        "Company",
                        "Location",
                        "Lat"
                    ],
                    ""
                ),
                "Lon" => $this->_getArrayValue(
                    $arrResponse,
                    [
                        "Company",
                        "Location",
                        "Lon"
                    ],
                    ""
                ),
                "Lng" => $this->_getArrayValue(
                    $arrResponse,
                    [
                        "Company",
                        "Location",
                        "Lng"
                    ],
                    ""
                )
            ],
            "AlexaRank" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "AlexaRank"
                ],
                null
            ),
            "Description" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "Description"
                ],
                null
            ),
            "Logo" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "Logo"
                ],
                ""
            ),
            "EmailAddresses" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "EmailAddresses"
                ],
                ""
            ),
            "Employees" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "Employees"
                ],
                null
            ),
            "EmployeeRange" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "EmployeeRange"
                ],
                ""
            ),
            "Industry" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "Industry"
                ],
                ""
            ),
            "IndustrySector" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "IndustrySector"
                ],
                ""
            ),
            "IndustryGroup" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "IndustryGroup"
                ],
                ""
            ),
            "IndustrySIC" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "IndustrySIC"
                ],
                ""
            ),
            "IndustryNAICS" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "IndustryNAICS"
                ],
                ""
            ),
            "MarketCap" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "MarketCap"
                ],
                ""
            ),
            "CompanyName" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "CompanyName"
                ],
                $this->_getArrayValue(
                    $arrResponse,
                    [
                        "IP",
                        "CompanyName"
                    ],
                    ""
                )
            ),
            "PhoneNumbers" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "PhoneNumbers"
                ],
                ""
            ),
            "Raised" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "Raised"
                ],
                ""
            ),
            "Revenue" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "Revenue"
                ],
                ""
            ),
            "RevenueEstimated" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "RevenueEstimated"
                ],
                ""
            ),
            "SocialMedia" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "SocialMedia"
                ],
                ""
            ),
            "Tags" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "Tags"
                ],
                ""
            ),
            "WebsiteURL" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Company",
                    "WebsiteURL"
                ],
                ""
            ),
            "CountryCode" => $this->_getArrayValue(
                $arrResponse,
                [
                    "IP",
                    "Location",
                    "CountryCode"
                ],
                ""
            ),
            "Lat" => $this->_getArrayValue(
                $arrResponse,
                [
                    "IP",
                    "Location",
                    "Lat"
                ],
                ""
            ),
            "Lon" => $this->_getArrayValue(
                $arrResponse,
                [
                    "IP",
                    "Location",
                    "Lon"
                ],
                ""
            ),
            "Region" => $this->_getArrayValue(
                $arrResponse,
                [
                    "IP",
                    "Location",
                    "Region"
                ],
                ""
            ),
            "Type" => $this->_getArrayValue(
                $arrResponse,
                [
                    "Type"
                ],
                ""
            ),
            "PostCode" => $this->_getArrayValue(
                $arrResponse,
                [
                    "IP",
                    "Location",
                    "PostCode"
                ],
                ""
            ),
            "City" => $this->_getArrayValue(
                $arrResponse,
                [
                    "IP",
                    "Location",
                    "City"
                ],
                ""
            ),
            "CountryCode" => $this->_getArrayValue(
                $arrResponse,
                [
                    "IP",
                    "Location",
                    "CountryCode"
                ],
                ""
            )
        ];

        if ($arrOldResponse["Type"] == 1 || $arrOldResponse["Type"] == 2) {
            $arrOldResponse["bIsISP"] = true;
        } else {
            $arrOldResponse["bIsISP"] = false;
        }

        $arrResponseToPass = [];
        foreach($arrOldResponse as $key => $value) {
            if (!is_array($value)) {
                if ($value || $key == "bIsISP" || ($key == "Type")) {
                    $arrResponseToPass[$key] = $value;
                }
            } else {
                if (
                    isset($arrOldResponse["Location"]) &&
                    isset($arrOldResponse["Location"]["Lat"]) &&
                    $arrOldResponse["Location"]["Lat"] != ""
                ) {
                    $arrResponseToPass["Location"] = $arrOldResponse["Location"];
                }
            }
        }
        return new Response\Company($arrResponseToPass);
    }
}
