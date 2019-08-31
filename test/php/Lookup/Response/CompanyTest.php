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
            "Hostname" => "canddi.com",
            "Type" => 1,
            "Company" => [
              "CompanyName" => "CANDDi",
              "PhoneNumbers" => [
                "+44 161 414 1080",
                "+442019063604",
                "+442009201947",
                "+44 (0) 161 414 1080"
              ],
              "WebsiteURL" => [
                "http =>//canddi.com"
              ],
              "Location" => [
                "Lat" => 53.48187619999999,
                "Lon" => -2.233166799999999,
                "Line1" => "47 Newton Street",
                "Line2" => "",
                "City" => "Manchester",
                "PostCode" => "M1 1FT",
                "Country" => "United Kingdom"
              ],
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
              "EmailAddresses" => [
                "hello@canddi.com"
              ],
              "Description" => "See the people and businesses visiting your website with Website Visitor Tracking Software CANDDI. Web User ID Analytics for marketing and lead generation.",
              "Logo" => "https =>//s3.eu-west-1.amazonaws.com/images.canddi.net/canddi.com/logo.png",
              "Industry" => "Internet Software & Services",
              "AlexaRank" => 1825479,
              "Employees" => 14,
              "EmployeeRange" => "11-50",
              "IndustrySector" => "Information Technology",
              "IndustryGroup" => "Software & Services",
              "IndustrySIC" => "73",
              "IndustryNAICS" => "54",
              "Raised" => 676528,
              "MarketCap" => 123456,
              "Revenue" => 9876,
              "RevenueEstimated" => "$1M-$10M",
              "Tags" => [
                "Technology",
                "Information Technology & Services",
                "Marketing & Advertising",
                "SAAS",
                "B2B"
              ]
            ]
        ];
    }
    public function testBasicGetters()
    {
        $testData = $this->_getTestData();
        $response = new Company($testData);

        $testCompanyData = $testData['Company'];
        $testLocationData = $testCompanyData['Location'];

        $this->assertEquals($testLocationData['City'], $response->getCity());
        $this->assertEquals($testLocationData['Lat'], $response->getLat());
        $this->assertEquals($testLocationData['Lon'], $response->getLon());
        $this->assertEquals($testLocationData['Line1'], $response->getLine1());
        $this->assertEquals($testLocationData['Line2'], $response->getLine2());
        $this->assertEquals($testLocationData['PostCode'], $response->getPostCode());
        $this->assertEquals($testLocationData['Country'], $response->getCountry());
        $this->assertEquals($testLocationData['City'], $response->getCity());
        $this->assertEquals($testCompanyData['AlexaRank'], $response->getAlexaRank());
        $this->assertEquals($testCompanyData['Description'], $response->getDescription());
        $this->assertEquals($testCompanyData['Logo'], $response->getLogo());
        $this->assertEquals($testCompanyData['EmailAddresses'], $response->getEmailAddresses());
        $this->assertEquals($testCompanyData['Employees'], $response->getEmployees());
        $this->assertEquals($testCompanyData['EmployeeRange'], $response->getEmployeeRange());
        $this->assertEquals($testCompanyData['Industry'], $response->getIndustry());
        $this->assertEquals($testCompanyData['IndustryGroup'], $response->getIndustryGroup());
        $this->assertEquals($testCompanyData['IndustryNAICS'], $response->getIndustryNAICS());
        $this->assertEquals($testCompanyData['IndustrySIC'], $response->getIndustrySIC());
        $this->assertEquals($testCompanyData['IndustrySector'], $response->getIndustrySector());
        $this->assertEquals($testCompanyData['MarketCap'], $response->getMarketCap());
        $this->assertEquals($testCompanyData['CompanyName'], $response->getName());
        $this->assertEquals($testCompanyData['PhoneNumbers'], $response->getPhones());
        $this->assertEquals($testCompanyData['Raised'], $response->getRaised());
        $this->assertEquals($testCompanyData['Revenue'], $response->getRevenue());
        $this->assertEquals($testCompanyData['RevenueEstimated'], $response->getRevenueEstimated());
        $this->assertEquals($testCompanyData['Tags'], $response->getTags());
        $this->assertEquals($testCompanyData['WebsiteURL'], $response->getWebsite());
        $this->assertEquals($testData['Type'], $response->getType());
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
            "platform" => "Facebook",
            "handle" => "thisiscanddi",
            "typeId" => "Facebook"
        ], $arrReturnedFacebook);
        $this->assertEquals([
            "url" => "twitter.com/50582574",
            "platform" => "Twitter",
            "handle" => "50582574",
            "typeId" => "Twitter"
        ], $arrReturnedTwitter);
        $this->assertEquals([
            "url" => "youtube.com/channel/UCU7aljz8YC9IdPfxuxLY39g",
            "platform" => "Youtube",
            "handle" => "UCU7aljz8YC9IdPfxuxLY39g",
            "typeId" => "Youtube"
        ], $arrReturnedYoutube);
        $this->assertEquals([
            "url" => "linkedin.com/company/canddi-campaign-and-digital-intelligence-limited-",
            "platform" => "LinkedIn",
            "handle" => "canddi-campaign-and-digital-intelligence-limited-",
            "typeId" => "LinkedIn"
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
