<?php
namespace CanddiAi\Lookup;


class AddressTest
    extends \CanddiAi\TestCase
{
    private $response;

    public function testLookupAddress()
    {
        $arrAddressData = [
            "CountryCode"      => "GB",
            "Lat"              => 53.4819035,
            "Lng"              => -2.2330543,
            "City"             => "Manchester",
            "Line1"            => "47 Newton Street",
            "Line2"            => "Greater Manchester",
            "Country"          => "United Kingdom",
            "PostalCode"       => "M1 1FT",
            "FormattedAddress" => "47 Newton Street, Manchester"
        ];

        $strBaseUri = 'baseuri.com';
        $strAccessToken = md5(1);
        $strAddress = $arrAddressData["FormattedAddress"];

        $strURL = sprintf(Address::c_URL_Address, rawurlencode($strAddress));
        $addressInstance = Address::getInstance($strBaseUri, $strAccessToken);
        $mockResponse = \Mockery::mock('GuzzleHttp\Psr7\Response')
            ->shouldReceive('getStatusCode')
            ->once()
            ->withNoArgs()
            ->andReturn(200)
            ->shouldReceive('getBody')
            ->once()
            ->withNoArgs()
            ->andReturn($this->_mockResponseBody(JSON_encode($arrAddressData)))
            ->mock();
        $mockGuzzle = \Mockery::mock('GuzzleHttp\Client')
            ->shouldReceive('request')
            ->once()
            ->with(
                'GET',
                $strURL,
                [
                    'query'         => []
                ]
            )
            ->andReturn($mockResponse)
            ->mock();
        Address::injectGuzzle($mockGuzzle);
        $actualAddressReponse = $addressInstance->lookupAddress($strAddress);
        $expectedAddressResponse = new Response\Address($arrAddressData);
        $this->assertEquals($expectedAddressResponse, $actualAddressReponse);
    }
}
