<?php
/**
 * @author Luke Roberts
 **/
namespace CanddiAi\Lookup;

class NormalizeNameTest
    extends \CanddiAi\TestCase
{
    public function testNormalizeName()
    {
        $strName = 'Logan White';

        $strBaseUri = 'https://ip.canddi.ai';
        $strAccessToken = md5(1);

        $strURL = sprintf(NormalizeName::c_URL_NORMALIZE, $strName);

        $normalizeNameInstance = NormalizeName::getInstance($strBaseUri, $strAccessToken);

        $responseBody = [
            "status" => "200",
            "requestId" => "20072030-ba42-4b6b-982e-2b0bc3ce923a",
            "likelihood" => 1,
            "nameDetails" => [
                "givenName" => "Logan",
                "familyName" => "White",
                "fullName" => "Logan White"
            ],
            "region" => "USA"
        ];

        $mockResponse = \Mockery::mock('GuzzleHttp\Psr7\Response')
            ->shouldReceive('getStatusCode')
            ->once()
            ->withNoArgs()
            ->andReturn(200)
            ->shouldReceive('getBody')
            ->once()
            ->withNoArgs()
            ->andReturn($this->_mockResponseBody(JSON_encode($responseBody)))
            ->mock();

        $mockGuzzle = \Mockery::mock('GuzzleHttp\Client')
            ->shouldReceive('request')
            ->once()
            ->with(
                'GET',
                $strURL,
                [
                    'query' => []
                ]
            )
            ->andReturn($mockResponse)
            ->mock();

        NormalizeName::injectGuzzle($mockGuzzle);

        $actualNormalizeResponse = $normalizeNameInstance->normalizeName($strName);
        $actualNormalizeResponse = $this->_getProtAttr($actualNormalizeResponse, '_arrResponse');

        $this->assertEquals($responseBody, $actualNormalizeResponse);
    }

    public function testNormalizeNameIncorrectName() {
        $strName = 'fakename';

        $strBaseUri = 'baseuri.com';
        $strAccessToken = md5(1);

        $strURL = sprintf(NormalizeName::c_URL_NORMALIZE, $strName);

        $normalizeNameInstance = NormalizeName::getInstance($strBaseUri, $strAccessToken);

        $this->setExpectedException(\Exception::class, 'NotFound: No names found for fakename');

        $mockResponse = \Mockery::mock('GuzzleHttp\Psr7\Response')
            ->shouldReceive('getStatusCode')
            ->twice()
            ->withNoArgs()
            ->andReturn(404)
            ->shouldReceive('getReasonPhrase')
            ->once()
            ->withNoArgs()
            ->andReturn('Service:NormalizeName returned error for (fakename): 404-{"errorMessage":"NotFound: No names found for fakename"}')
            ->mock();

        $mockGuzzle = \Mockery::mock('GuzzleHttp\Client')
            ->shouldReceive('request')
            ->once()
            ->with(
                'GET',
                $strURL,
                [
                    'query' => []
                ]
            )
            ->andReturn($mockResponse)
            ->mock();

        NormalizeName::injectGuzzle($mockGuzzle);

        $response = $normalizeNameInstance->normalizeName($strName);
    }
}
