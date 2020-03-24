<?php
namespace CanddiAi\Lookup\Response;

use \CanddiAi\TestCase as TestCase;

class CompanyTest
    extends TestCase
{
    private $response;

    private function _getTestData()
    {
        return [
            "Location" => [
                    "Address" => [
                            "Line1" => "47 Newton Street",
                            "Line2" => "",
                            "PostalCode" => "M1 1FT",
                            "PostCode" => "M1 1FT",
                            "City" => "Manchester",
                            "Country" => "",
                    ],
                    "FormattedAddress" => "",
                    "Region" => "",
                    "CountryCode" => "",
                    "Lat" => "53.4818762",
                    "Lon" => "-2.2331668",
                    "Lng" => "-2.2331668"
            ],
            "AlexaRank" => "1825479",
            "Description" => "See the people and businesses visiting your website with Website Visitor Tracking Software CANDDI. Web User ID Analytics for marketing and lead generation.",
            "Logo" => "https://s3.eu-west-1.amazonaws.com/images.canddi.net/canddi.com/logo.png",
            "EmailAddresses" => [
                    "hello@canddi.com"
                ],
            "Employees" => "14",
            "EmployeeRange" => "11-50",
            "Industry" => "Internet Software & Services",
            "IndustrySector" => "Information Technology",
            "IndustryGroup" => "Software & Services",
            "IndustrySIC" => "73",
            "IndustryNAICS" => "54",
            "MarketCap" => "",
            "CompanyName" => "CANDDi",
            "PhoneNumbers" => [
                    "+44 161 414 1080",
                    "+442019063604",
                    "+442009201947",
                    "+44 [0] 161 414 1080"
                ],
            "Raised" => "676528",
            "Revenue" => "",
            "RevenueEstimated" => "$1M-$10M",
            "SocialMedia" => [
                    "Facebook" => [
                            "url" => "facebook.com/thisiscanddi",
                            "platform" => "Facebook",
                            "handle" => "thisiscanddi"
                        ],
                    "Twitter" => [
                            "url" => "twitter.com/50582574",
                            "platform" => "Twitter",
                            "handle" => "50582574"
                        ],
                    "Youtube" => [
                            "url" => "youtube.com/channel/UCU7aljz8YC9IdPfxuxLY39g",
                            "platform" => "Youtube",
                            "handle" => "UCU7aljz8YC9IdPfxuxLY39g"
                        ],
                    "LinkedIn" => [
                            "url" => "linkedin.com/company/canddi-campaign-and-digital-intelligence-limited-",
                            "platform" => "LinkedIn",
                            "handle" => "canddi-campaign-and-digital-intelligence-limited-"
                    ]
            ],
            "Tags" => [
                    "Technology",
                    "Information Technology & Services",
                    "Marketing & Advertising",
                    "SAAS",
                    "B2B"
            ],
            "WebsiteURL" => [
                    "http://canddi.com"
            ],
            "CountryCode" => "",
            "Lat" => "",
            "Lon" => "",
            "Region" => "",
            "Type" => 3,
            "PostCode" => "",
            "City" => "",
            "Hostname" => 'canddi.com',
            "bIsISP" => false
        ];
    }
    public function testBasicGetters()
    {
        $testData = $this->_getTestData();
        $response = new Company($testData);

        $testData_Location = $testData['Location'];
        $testData_Address = $testData_Location['Address'];

        $this->assertEquals($testData_Address['City'], $response->getAddressCity());
        $this->assertEquals($testData_Location['Lat'], $response->getAddressLat());
        $this->assertEquals($testData_Location['Lng'], $response->getAddressLon());
        $this->assertEquals($testData_Address['Line1'], $response->getAddressLine1());
        $this->assertEquals($testData_Address['Line2'], $response->getAddressLine2());
        $this->assertEquals($testData_Address['PostalCode'], $response->getAddressPostCode());
        $this->assertEquals($testData['AlexaRank'], $response->getAlexaRank());
        $this->assertEquals($testData['City'], $response->getCity());
        $this->assertEquals($testData['CountryCode'], $response->getCountryCode());
        $this->assertEquals($testData['Description'], $response->getDescription());
        $this->assertEquals($testData['Logo'], $response->getLogo());
        $this->assertEquals($testData['EmailAddresses'], $response->getEmailAddresses());
        $this->assertEquals($testData['Employees'], $response->getEmployees());
        $this->assertEquals($testData['EmployeeRange'], $response->getEmployeeRange());
        $this->assertEquals($testData['Industry'], $response->getIndustry());
        $this->assertEquals($testData['IndustryGroup'], $response->getIndustryGroup());
        $this->assertEquals($testData['IndustryNAICS'], $response->getIndustryNAICS());
        $this->assertEquals($testData['IndustrySIC'], $response->getIndustrySIC());
        $this->assertEquals($testData['IndustrySector'], $response->getIndustrySector());
        $this->assertEquals($testData['Lat'], $response->getLat());
        $this->assertEquals($testData_Location, $response->getLocation());
        $this->assertEquals($testData_Address, $response->getLocationAddress());
        $this->assertEquals($testData['Lon'], $response->getLon());
        $this->assertEquals($testData['MarketCap'], $response->getMarketCap());
        $this->assertEquals($testData['CompanyName'], $response->getName());
        $this->assertEquals($testData['PhoneNumbers'], $response->getPhones());
        $this->assertEquals($testData_Address['PostCode'], $response->getPostCode());
        $this->assertEquals($testData['Raised'], $response->getRaised());
        $this->assertEquals($testData['Revenue'], $response->getRevenue());
        $this->assertEquals($testData['RevenueEstimated'], $response->getRevenueEstimated());
        $this->assertEquals($testData['Tags'], $response->getTags());
        $this->assertEquals($testData['Type'], $response->getType());
        $this->assertEquals($testData['WebsiteURL'], $response->getWebsite());
        $this->assertEquals($testData['bIsISP'], $response->isISP());
        $this->assertEquals($testData['PostCode'], $response->getPostCode_Outer());
        $this->assertEquals($testData['Hostname'], $response->getHostname());
    }
    public function testGetSocialProfiles()
    {
        $testData = $this->_getTestData();
        $response = new Company($testData);

        $arrReturnedSocialProfiles = $response->getSocialProfiles();
        $arrReturnedFacebook = $this->_getProtAttr($arrReturnedSocialProfiles[0], '_arrResponse');
        $arrReturnedTwitter = $this->_getProtAttr($arrReturnedSocialProfiles[1], '_arrResponse');
        $arrReturnedYoutube = $this->_getProtAttr($arrReturnedSocialProfiles[2], '_arrResponse');
        $arrReturnedLinkedIn = $this->_getProtAttr($arrReturnedSocialProfiles[3], '_arrResponse');
        $this->assertEquals([
            "url" => "facebook.com/thisiscanddi",
            "handle" => "thisiscanddi",
            "typeId" => "Facebook",
            "platform" => "Facebook"
        ], $arrReturnedFacebook);
        $this->assertEquals([
            "url" => "twitter.com/50582574",
            "handle" => "50582574",
            "typeId" => "Twitter",
            "platform" => "Twitter"
        ], $arrReturnedTwitter);
        $this->assertEquals([
            "url" => "youtube.com/channel/UCU7aljz8YC9IdPfxuxLY39g",
            "handle" => "UCU7aljz8YC9IdPfxuxLY39g",
            "typeId" => "Youtube",
            "platform" => "Youtube"
        ], $arrReturnedYoutube);
        $this->assertEquals([
            "url" => "linkedin.com/company/canddi-campaign-and-digital-intelligence-limited-",
            "handle" => "canddi-campaign-and-digital-intelligence-limited-",
            "typeId" => "LinkedIn",
            "platform" => "LinkedIn"
        ], $arrReturnedLinkedIn);
    }

    // public function testGetCoreCompany()
    // {
    //     // First lets test that missing company name results in null return
    //     $responseEmpty = new Company([]);
    //     $this->assertNull($responseEmpty->getCoreCompany());

    //     // Now lets test that all the data gets into the core properly
    //     $testData = $this->_getTestData();
    //     $response = new Company($testData);
    //     $coreCompany = $response->getCoreCompany();

    //     $testDataSocial = $testData['SocialMedia'];
    //     $testDataAddress = $testData['Location']['Address'];
    //     $this->assertInstanceOf(Canddi_Core_Company::class, $coreCompany);
    //     $this->assertEquals($testData['CompanyName'], $coreCompany->getCompanyName());
    //     $this->assertEquals($testData['Description'], $coreCompany->getCompanyDescription());
    //     $this->assertEquals($testDataSocial['Facebook']['url'], $coreCompany->getCompanyFacebook());
    //     $this->assertEquals($testDataSocial['Twitter']['url'], $coreCompany->getCompanyTwitter());
    //     $this->assertEquals($testDataSocial['LinkedIn']['url'], $coreCompany->getCompanyLinkedIn());
    //     $this->assertEquals($testData['Logo'], $coreCompany->getCompanyLogo());
    //     $this->assertEquals($testData['Industry'], $coreCompany->getCompanyIndustry());
    //     $this->assertEquals($testData['WebsiteURL'], $coreCompany->getCompanyWebsite());
    //     $this->assertEquals($testData['PhoneNumbers'], $coreCompany->getCompanyPhones());
    //     $this->assertEquals($testData['EmailAddresses'], $coreCompany->getCompanyEmails());
    //     $this->assertEquals($testDataAddress['Line1'], $coreCompany->getCompanyAddrLine1());
    //     $this->assertEquals($testDataAddress['Line2'], $coreCompany->getCompanyAddrLine2());
    //     $this->assertEquals($testDataAddress['City'], $coreCompany->getCompanyAddrCity());
    //     $this->assertEquals($testDataAddress['PostalCode'], $coreCompany->getCompanyAddrPostalCode());
    //     $this->assertEquals($testData['IndustrySector'], $coreCompany->getIndustrySector());
    //     $this->assertEquals($testData['IndustryGroup'], $coreCompany->getIndustryGroup());
    //     $this->assertEquals($testData['IndustrySIC'], $coreCompany->getIndustrySIC());
    //     $this->assertEquals($testData['IndustryNAICS'], $coreCompany->getIndustryNAICS());
    //     $this->assertEquals($testData['Tags'], $coreCompany->getTags());
    //     $this->assertEquals($testData['AlexaRank'], $coreCompany->getAlexaRank());
    //     $this->assertEquals($testData['Employees'], $coreCompany->getNoEmployees());
    //     $this->assertEquals($testData['EmployeeRange'], $coreCompany->getEmployeeRange());
    //     $this->assertEquals($testData['MarketCap'], $coreCompany->getMarketCap());
    //     $this->assertEquals($testData['Raised'], $coreCompany->getRaised());
    //     $this->assertEquals($testData['Revenue'], $coreCompany->getRevenue());
    //     $this->assertEquals($testData['RevenueEstimated'], $coreCompany->getRevenueRange());
    // }
    // public function testGetCoreLocation()
    // {
    //     // First lets test that no location object means null return value
    //     $responseEmpty = new Company(['Location' => []]);
    //     $this->assertNull($responseEmpty->getCoreLocation());

    //     // Now test that missing Lat or Lng means null return value
    //     $responseNoLat = new Company([
    //         'Location' => [
    //             'Lng' => 10,
    //             'Lat' => null
    //         ]
    //     ]);
    //     $this->assertNull($responseNoLat->getCoreLocation());
    //     $responseNoLng = new Company([
    //         'Location' => [
    //             'Lng' => null,
    //             'Lat' => 10
    //         ]
    //     ]);
    //     $this->assertNull($responseNoLng->getCoreLocation());

    //     // Now test that the core location is created properly
    //     $testData = $this->_getTestData();
    //     $response = new Company($testData);
    //     $coreLocation = $response->getCoreLocation();

    //     $testDataLocation = $testData['Location'];
    //     $this->assertEquals($testDataLocation['Lat'], $coreLocation->getLatitude());
    //     $this->assertEquals($testDataLocation['Lng'], $coreLocation->getLongitude());
    //     $this->assertEquals(Canddi_Core_Location::TYPE_FIXED_ADDRESS, $coreLocation->getIPType());
    // }
}
