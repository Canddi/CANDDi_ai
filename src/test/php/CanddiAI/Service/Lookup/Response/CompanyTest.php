<?php

class CompanyTest
    extends Canddi_TestCase
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
            "Logo" => "https:\/\/s3-eu-west-1.amazonaws.com\/images.canddi.net\/canddi.com\/logo.png",
            "Industry" => "Advertising Agency",
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

        $response = new CanddiAI\Response\Company($testData);

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
        $response = new CanddiAI\Response\Company($testData);

        $this->assertEquals([], $response->getLocation());
    }

    public function testGetLat()
    {
        // This (along with Lon, City & CountryCode) is for IP lookup data, so it's not from the location object
        $testData = $this->_getTestData();
        $response = new CanddiAI\Response\Company($testData);

        $intExpectedLat = 15.4;
        $intReturnedLat = $response->getLat();

        $this->assertEquals($intExpectedLat, $intReturnedLat);
    }
    public function testGetLon()
    {
        $testData = $this->_getTestData();
        $response = new CanddiAI\Response\Company($testData);

        $strExpectedLon = 12.3;
        $strReturnedLon = $response->getLon();
        $this->assertEquals($strExpectedLon, $strReturnedLon);
    }
    public function testGetCity()
    {
        $testData = $this->_getTestData();
        $response = new CanddiAI\Response\Company($testData);

        $strExpectedCity = "Manchester";
        $strReturnedCity = $response->getCity();
        $this->assertEquals($strExpectedCity, $strReturnedCity);
    }
    public function testGetCountryCode()
    {
        $testData = $this->_getTestData();
        $response = new CanddiAI\Response\Company($testData);

        $strExpectedCountryCode = "GB";
        $strReturnedCountryCode = $response->getCountryCode();
        $this->assertEquals($strExpectedCountryCode, $strReturnedCountryCode);
    }
    public function testGetDescription()
    {
        $testData = $this->_getTestData();
        $response = new CanddiAI\Response\Company($testData);

        $strExpectedDescription = "CANDDi tells you which businesses and people are on your website - helping you convert your visitors into sales! Book a free online demo today. ";
        $strReturnedDescription = $response->getDescription();
        $this->assertEquals($strExpectedDescription, $strReturnedDescription);
    }
    public function testGetWebsite()
    {
        $testData = $this->_getTestData();
        $response = new CanddiAI\Response\Company($testData);

        $strExpectedWebsite = "http:\/\/canddi.com";
        $strReturnedWebsite = $response->getWebsite();
        $this->assertEquals($strExpectedWebsite, $strReturnedWebsite);
    }
    public function testGetEmailAddresses()
    {
        $testData = $this->_getTestData();
        $response = new CanddiAI\Response\Company($testData);

        $strExpectedEmailAddresses = [
            "hello@canddi.com",
            "goodbye@canddi.com"
        ];
        $strReturnedEmailAddresses = $response->getEmailAddresses();
        $this->assertEquals($strExpectedEmailAddresses, $strReturnedEmailAddresses);
    }
    public function testGetSocialProfiles()
    {
        $testData = $this->_getTestData();
        $response = new CanddiAI\Response\Company($testData);

        $strExpectedSocialProfiles = [
          new CanddiAI\Response\Item\Social([
            'url' => 'facebook.com\\/pages\\/Canddi\\/126078980739722',
            'handle' => 'Canddi',
            'id' => '126078980739722',
            'username' => 'thisiscanddi',
            'typeId' => 'Facebook',
          ]),
          new CanddiAI\Response\Item\Social([
            'url' => 'twitter.com\\/CANDDi',
            'handle' => 'CANDDi',
            'id' => '50582574',
            'followers' => 19751,
            'verified' => false,
            'typeId' => 'Twitter',
          ]),
        ];
        $strReturnedSocialProfiles = $response->getSocialProfiles();

        $this->assertEquals($strExpectedSocialProfiles, $strReturnedSocialProfiles);
    }
}
