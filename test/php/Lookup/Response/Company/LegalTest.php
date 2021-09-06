<?php

namespace CanddiAi\Lookup\Response\Company;

class LegalTest
    extends \CanddiAi\TestCase
{
    private function _getTestData()
    {
        return [
            "LegalName" => "CAMPAIGN AND DIGITAL INTELLIGENCE",
            "CRN" => "07066939",
            "IncorporationDate" => "2009-11-05",
            "CompanyType" => "private limited company",
            "RegisteredLocation" => [
                "Lat" => 53.4819,
                "Lng" => -2.2331,
                "Line1" => "47 Newton Street",
                "Line2" => "City Centre",
                "PostCode" => "M1 1FT",
                "City" => "Manchester",
                "CountryCode" => "GB",
                "Region" => "ENG"
            ]
        ];
    }
    public function testCreateAndGetters()
    {
        
        $testData = $this->_getTestData();
        $response = new Legal($testData);
        
        $this->assertEquals($testData[Legal::KEY_LEGALNAME], $response->getLegalName());
        $this->assertEquals($testData[Legal::KEY_CRN], $response->getCRN());
        $this->assertEquals($testData[Legal::KEY_INCORPORATIONDATE], $response->getIncorporationDate());
        $this->assertEquals($testData[Legal::KEY_COMPANYTYPE], $response->getCompanyType());

        $registeredLocation = $response->getRegisteredLocation();
        $locationTestData = $testData[Legal::KEY_REGISTEREDLOCATION];
        $this->assertInstanceOf(Location::class, $registeredLocation);
        $this->assertEquals($locationTestData[Location::KEY_LAT], $registeredLocation->getLat());
        $this->assertEquals($locationTestData[Location::KEY_LNG], $registeredLocation->getLng());
    }
}
