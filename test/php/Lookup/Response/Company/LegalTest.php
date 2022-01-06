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
            ],
            "Financial" => [
                "CreditWorthy" => 1,
                "NegativeIndicator" => 0,
                "FilingDate" => 1629244800,
                "AnnualReturnDate" => 1615593600,
                "AccDueDate" => 1672444800,
                "InternationalScore" => "B",
                "InternationalScoreDate" => 1629590400,
                "MadeUptoDate" => 1617148800,
                "Currency" => "GBP",
                "ConsolidatedAcs" => 0,
                "AccountsFormat" => 1,
                "Turnover" => 939343,
                "TurnoverRange" => "The range",
                "PreTaxProfit" => 127500,
                "ProfitAfterTax" => 167309,
                "Cash" => 122353,
                "TotalCurrentAssets" => 443684,
                "TotalAssets" => 482542,
                "TotalLiabilities" => 182827,
                "ShareholderFunds" => 299715,
                "NetWorth" => 299715,
                "NumberOfEmployees" => 20,
                "CurrentRatio" => 4.05,
                "Auditors" => null,
                "AccountantName" => "POMEGRATE CONSULTING LIMITED"
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

        $financial = $response->getFinancial();
        $locationTestData = $testData[Legal::KEY_FINANCIAL];
        $this->assertInstanceOf(Financial::class, $financial);
        $this->assertEquals($locationTestData[Financial::KEY_TURNOVER], $financial->getTurnover());
        $this->assertEquals($locationTestData[Financial::KEY_TURNOVER_RANGE], $financial->getTurnoverRange());
        $this->assertEquals($locationTestData[Financial::KEY_CURRENCY], $financial->getCurrency());
    }
}
