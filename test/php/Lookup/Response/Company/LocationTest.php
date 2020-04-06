<?php
namespace CanddiAi\Lookup\Response\Company;

use \CanddiAi\TestCase as TestCase;

class LocationTest
    extends TestCase
{
    private function _getTestData()
    {
        return [
            "Lat"           => 53.4606,
            "Lng"           => -2.2572,
            "Line1"         => "47 Newton Street",
            "Line2"         => "Manchester",
            "PostCode"      => "M1 1FT",
            "City"          => "Manchester",
            "CountryCode"   => "GB"
        ];
    }

    public function testGetters()
    {
        $innerLocation = new Location($this->_getTestData());

        $this->assertEquals(
            $this->_getTestData()['City'],
            $innerLocation->getCity()
        );
        $this->assertEquals(
            $this->_getTestData()['CountryCode'],
            $innerLocation->getCountryCode()
        );
        $this->assertEquals(
            $this->_getTestData()['Lat'],
            $innerLocation->getLat()
        );
        $this->assertEquals(
            $this->_getTestData()['Lng'],
            $innerLocation->getLng()
        );
        $this->assertEquals(
            $this->_getTestData()['Lon'],
            $innerLocation->getLon()
        );
        $this->assertEquals(
            $this->_getTestData()['Line1'],
            $innerLocation->getLine1()
        );
        $this->assertEquals(
            $this->_getTestData()['Line2'],
            $innerLocation->getLine2()
        );
        $this->assertEquals(
            $this->_getTestData()['PostCode'],
            $innerLocation->getPostCode()
        );
    }
}
