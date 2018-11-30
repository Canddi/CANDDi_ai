<?php

namespace CanddiAI\Response;

class CompanyTest
    extends \CanddiAI\CanddiAI_TestCase
{
    private $response;

    private function _getTestData()
    {
        return array(
            "City" => "Manchester",
            "CompanyName" => "Canddi",
            "CountryCode" => "GB",
            "Description" => "CANDDi tells you which businesses and people are on your website - helping you convert your visitors into sales! Book a free online demo today. ",
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
                )
            ),
            "EmailAddresses" => array(
                "hello@canddi.com",
                "goodbye@canddi.com"
            ),
            "CRN" => "07066939",
            "AlexaRank" => 14682,
            "Logo" => "https:\/\/s3-eu-west-1.amazonaws.com\/images.canddi.net\/canddi.com\/logo.png",
            "Employees" => 22,
            "EmployeeRange" => "1-30",
            "Industry" => "Advertising Agency",
            "Industry" => "Internet Software & Services",
            "IndustrySector" => "Information Technology",
            "IndustryGroup" => "Software & Services",
            "IndustrySIC" => "73",
            "IndustryNAICS" => "54",
            "MarketCap" => "",
            "WebsiteURL" => "http:\/\/canddi.com",
            "PhoneNumbers" => [
                "+44 (0) 161 414 1080",
                "+44 161 414 1080"
            ],
            "PostCode" => "M1 1FT",
            "Raised" => 692600,
            "Region" => "Manchester",
            "Revenue" => 542139000,
            "RevenueEstimated" => "$500M-$1B",
            "Location" => array(
                "FormattedAddress" => "47 Newton St, Manchester M1 1FT, UK",
                "Lat" => 53.4818762,
                "Lng" => -2.2331668,
                "Address" => array(
                    "Line1" => "47 Newton Street",
                    "Line2" => "",
                    "City" => "Manchester",
                    "PostalCode" => "M1 1FT",
                    "Country" => "United Kingdom"
                )
            ),
            "Lat" => 15.4,
            "Lon" => 12.3
        );
    }

    public function testGetLocation()
    {
        $testData = $this->_getTestData();

        $response = new Company($testData);

        $arrExpectedLocation = [
            "FormattedAddress" => "47 Newton St, Manchester M1 1FT, UK",
            "Lat" => 53.4818762,
            "Lng" => -2.2331668,
            "Address" => [
                "Line1" => "47 Newton Street",
                "Line2" => "",
                "City" => "Manchester",
                "PostalCode" => "M1 1FT",
                "Country" => "United Kingdom"
            ]
        ];
        $arrReturnedLocation = $response->getLocation();

        $this->assertEquals($arrExpectedLocation, $arrReturnedLocation);

        // Test to make sure it returns an empty array when there's no location
        unset($testData["Location"]);
        $response = new Company($testData);

        $this->assertEquals([], $response->getLocation());
    }

    public function testGetSocialProfiles()
    {
        $testData = $this->_getTestData();
        $response = new Company($testData);

        $arrExpectedSocialProfiles = [
          new Item\Social([
            'url' => 'facebook.com\\/pages\\/Canddi\\/126078980739722',
            'handle' => 'Canddi',
            'id' => '126078980739722',
            'username' => 'thisiscanddi',
            'typeId' => 'Facebook',
          ]),
          new Item\Social([
            'url' => 'twitter.com\\/CANDDi',
            'handle' => 'CANDDi',
            'id' => '50582574',
            'followers' => 19751,
            'verified' => false,
            'typeId' => 'Twitter',
          ]),
        ];
        $arrReturnedSocialProfiles = $response->getSocialProfiles();

    }

    public function testGetters() {
        $testData = $this->_getTestData();
        $response = new Company($testData);

        $this->assertEquals($testData['Lat'], $response->getLat());
        $this->assertEquals($testData['Lon'], $response->getLon());
        $this->assertEquals($testData['City'], $response->getCity());
        $this->assertEquals($testData['CountryCode'], $response->getCountryCode());
        $this->assertEquals($testData['CountryCode'], $response->getCountryCode());
        $this->assertEquals($testData['Description'], $response->getDescription());
        $this->assertEquals($testData['WebsiteURL'], $response->getWebsite());
        $this->assertEquals($testData['EmailAddresses'], $response->getEmailAddresses());
        $this->assertEquals($testData['AlexaRank'], $response->getAlexaRank());
        $this->assertEquals($testData['Logo'], $response->getLogo());
        $this->assertEquals($testData['Employees'], $response->getEmployees());
        $this->assertEquals($testData['EmployeeRange'], $response->getEmployeeRange());
        $this->assertEquals($testData['Industry'], $response->getIndustry());
        $this->assertEquals($testData['IndustryGroup'], $response->getIndustryGroup());
        $this->assertEquals($testData['IndustryNAICS'], $response->getIndustryNAICS());
        $this->assertEquals($testData['IndustrySector'], $response->getIndustrySector());
        $this->assertEquals($testData['IndustrySIC'], $response->getIndustrySIC());
        $this->assertEquals($testData['MarketCap'], $response->getMarketCap());
        $this->assertEquals($testData['CompanyName'], $response->getName());
        $this->assertEquals($testData['PhoneNumbers'], $response->getPhones());
        $this->assertEquals($testData['Raised'], $response->getRaised());
        $this->assertEquals($testData['Region'], $response->getRegion());
        $this->assertEquals($testData['Revenue'], $response->getRevenue());
        $this->assertEquals($testData['RevenueEstimated'], $response->getRevenueEstimated());
        $this->assertEquals([], $response->getTags());
    }
}
