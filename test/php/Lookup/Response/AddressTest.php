<?php
namespace CanddiAi\Lookup;


class AddressResponseTest
    extends \CanddiAi\TestCase
{
    public function testConstruct()
    {
        $arrAddressData = [
            "Lat"              => 53.4819035,
            "Lng"              => -2.2330543,
            "City"             => "Manchester",
            "Line1"            => "47 Newton Street",
            "Line2"            => "Greater Manchester",
            "Country"          => "United Kingdom",
            "PostalCode"       => "M1 1FT",
            "FormattedAddress" => "47 Newton Street, Manchester"
        ];

        $response = new Response\Address($arrAddressData);

        $this->assertEquals($arrAddressData['Lat'], $response->getLat());
        $this->assertEquals($arrAddressData['Lng'], $response->getLng());
        $this->assertEquals($arrAddressData['City'], $response->getCity());
        $this->assertEquals($arrAddressData['Line1'], $response->getLine1());
        $this->assertEquals($arrAddressData['Line2'], $response->getLine2());
        $this->assertEquals($arrAddressData['Country'], $response->getCountry());
        $this->assertEquals($arrAddressData['PostalCode'], $response->getPostalCode());
        $this->assertEquals($arrAddressData['FormattedAddress'], $response->getFormattedAddress());
    }
}
