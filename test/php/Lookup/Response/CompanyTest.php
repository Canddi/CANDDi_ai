<?php
namespace CanddiAi\Lookup\Response;

use \CanddiAi\TestCase as TestCase;

class CompanyTest
    extends TestCase
{
    private $response;

    private function _getTestData()
    {
        return array(
            "City" => "Manchester",
            "CompanyName" => "Canddi",
            "CountryCode" => "GB",
            "Description" => "CANDDi tells you which businesses and people are on your website - helping you convert your visitors into sales! Book a free online demo today.",
            "Heading" => "Find out WHO is on your website",
            "SocialMedia" => array(
                "Facebook" => array(
                    "url" => "facebook.com\/pages\/Canddi\/126078980739722",
                    "handle" => "Canddi",
                    "id" => "126078980739722",
                    "username" => "thisiscanddi"
                ),
                "Twitter" => array(
                    "url" => "twitter.com\/CANDDi",
                    "handle" => "CANDDi",
                    "id" => "50582574",
                    "followers" => 19751,
                    "verified" => false
                ),
                "LinkedIn" => array(
                    "url" => "linkedin.com\/company\/canddi-campaign-and-digital-intelligence-limited-"
                ),
                "ObscureSocialMediaSite" => array(
                    "url" => "fakeURL"
                )
            ),
            "EmailAddresses" => array(
                "hello@canddi.com",
                "goodbye@canddi.com"
            ),
            "CRN" => "07066939",
            "Logo" => "https:\/\/s3-eu-west-1.amazonaws.com\/images.canddi.net\/canddi.com\/logo.png",
            "Industry" => "Advertising Agency",
            "IndustrySector" => "IT",
            "IndustryGroup" => "IT Group",
            "IndustrySIC" => "8748",
            "IndustryNAICS" => "541990",
            "WebsiteURL" => "http:\/\/canddi.com",
            "PhoneNumbers" => [
                "+44 (0) 161 414 1080",
                "+44 161 414 1080"
            ],
            "Location" => array(
                "FormattedAddress" => "47 Newton St, Manchester M1 1FT, UK",
                "Lat" => 53.4818762,
                "Lng" => -2.2331668,
                "Address" => array(
                    "Line1" => "47 Newton Street",
                    "Line2" => "",
                    "City" => "Manchester",
                    "PostalCode" => "M1 1FT",
                    "PostCode" => "m1 1ft",
                    "Country" => "United Kingdom"
                )
            ),
            "Lat" => 15.4,
            "Lon" => 12.3,
            "bIsISP" => false,
            "Tags" => ['IT', 'Marketing'],
            "AlexaRank" => 9999,
            "Employees" => 15,
            "EmployeeRange" => '10-50',
            "MarketCap" => 1000000,
            "Raised" => 500000,
            "Revenue" => 700000,
            "RevenueEstimated" => '$1m',
            "Type" => 3,
            "PostCode" => "M22"
        );
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
    }
    public function testGetSocialProfiles()
    {
        $testData = $this->_getTestData();
        $response = new Company($testData);

        $arrReturnedSocialProfiles = $response->getSocialProfiles();
        $arrReturnedFacebook = $this->_getProtAttr($arrReturnedSocialProfiles[0], '_arrResponse');
        $arrReturnedTwitter = $this->_getProtAttr($arrReturnedSocialProfiles[1], '_arrResponse');
        $arrReturnedLinkedIn = $this->_getProtAttr($arrReturnedSocialProfiles[2], '_arrResponse');
        $this->assertEquals([
            "url" => "facebook.com\/pages\/Canddi\/126078980739722",
            "handle" => "Canddi",
            "id" => "126078980739722",
            "username" => "thisiscanddi",
            "typeId" => "Facebook"
        ], $arrReturnedFacebook);
        $this->assertEquals([
            "url" => "twitter.com\/CANDDi",
            "handle" => "CANDDi",
            "id" => "50582574",
            "followers" => 19751,
            "verified" => false,
            "typeId" => "Twitter"
        ], $arrReturnedTwitter);
        $this->assertEquals([
            "url" => "linkedin.com\/company\/canddi-campaign-and-digital-intelligence-limited-",
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
