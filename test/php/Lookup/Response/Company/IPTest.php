<?php
namespace CanddiAi\Lookup\Response\Company;

use \CanddiAi\TestCase as TestCase;

class IPTest
    extends TestCase
{
    private function _getTestData()
    {
        return [
            "StartIP"     => "84.13.20.215",
            "EndIP"   => "84.13.20.215",
            "Lat"     => 53.4606,
            "Lng"     => -2.2572,
            "IPRange"     => 0,
            "CompanyName"     => "1410143447-canddi.com",
            "IPAddress"   => "84.13.20.215",
            "Location"    => [
                "Lat"   => 53.4606,
                "Lng"   => -2.2572,
                "Line1"     => "",
                "Line2"     => "",
                "PostCode"  => "M16",
                "City"  => "Manchester",
                "CountryCode"   => ""
            ]
        ];
    }

    public function testGetters()
    {
        $innerIP = new IP($this->_getTestData());

        $this->assertEquals(
            $this->_getTestData()['StartIP'],
            $innerIP->getStartIP()
        );
        $this->assertEquals(
            $this->_getTestData()['EndIP'],
            $innerIP->getEndIP()
        );
        $this->assertEquals(
            $this->_getTestData()['IPRange'],
            $innerIP->getIPRange()
        );
        $this->assertEquals(
            $this->_getTestData()['IPAddress'],
            $innerIP->getIPAddress()
        );
        $this->assertEquals(
            $this->_getTestData()['CompanyName'],
            $innerIP->getCompanyName()
        );
        $this->assertInstanceOf(
            Location::class,
            $innerIP->getLocation()
        );
        $this->assertEquals(
            $this->_getTestData()['Lat'],
            $innerIP->getLat()
        );
        $this->assertEquals(
            $this->_getTestData()['Lng'],
            $innerIP->getLon()
        );
        $this->assertEquals(
            $this->_getTestData()['CountryCode'],
            $innerIP->getCountryCode()
        );
    }
}
