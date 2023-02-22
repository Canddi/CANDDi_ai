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
            "IsCloudHost"   =>  null,
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
        $CompanyIP = new IP($this->_getTestData());

        $this->assertEquals(
            $this->_getTestData()['StartIP'],
            $CompanyIP->getStartIP()
        );
        $this->assertEquals(
            $this->_getTestData()['EndIP'],
            $CompanyIP->getEndIP()
        );
        $this->assertEquals(
            $this->_getTestData()['IPRange'],
            $CompanyIP->getIPRange()
        );
        $this->assertEquals(
            $this->_getTestData()['IPAddress'],
            $CompanyIP->getIPAddress()
        );
        $this->assertEquals(
            $this->_getTestData()['CompanyName'],
            $CompanyIP->getCompanyName()
        );
        $this->assertInstanceOf(
            Location::class,
            $CompanyIP->getLocation()
        );
        $this->assertEquals(
            $this->_getTestData()['Lat'],
            $CompanyIP->getLat()
        );
        $this->assertEquals(
            $this->_getTestData()['Lng'],
            $CompanyIP->getLon()
        );
        $this->assertEquals(
            $this->_getTestData()['Location']['CountryCode'],
            $CompanyIP->getCountryCode()
        );
        $this->assertEquals(
            $this->_getTestData()['IsCloudHost'],
            $CompanyIP->getIsCloudHost()
        );
    }
}
