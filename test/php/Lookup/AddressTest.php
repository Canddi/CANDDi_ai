<?php
namespace CanddiAi\Lookup;


class AddressTest
    extends \CanddiAi\TestCase
{
    private $response;

    public function testLookupAddress()
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

        $strBaseUri = 'baseuri.com';
        $strApiKey = 'api_key_v4387yt876y745';
        $strAddress = $arrAddressData["FormattedAddress"];

        $strURL = sprintf(Address::c_URL_Address, rawurlencode($strAddress));
        $addressInstance = Address::getInstance($strBaseUri, $strApiKey);
        $mockResponse = \Mockery::mock('GuzzleHttp\Psr7\Response')
            ->shouldReceive('getStatusCode')
            ->once()
            ->withNoArgs()
            ->andReturn(200)
            ->shouldReceive('getBody')
            ->once()
            ->withNoArgs()
            ->andReturn(JSON_encode($arrAddressData))
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
